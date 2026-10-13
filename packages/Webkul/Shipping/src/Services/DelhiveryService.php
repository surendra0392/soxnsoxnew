<?php

namespace Webkul\Shipping\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DelhiveryService
{
    /**
     * Check if Delhivery integration is enabled.
     */
    public function isActive(): bool
    {
        return (bool) core()->getConfigData('sales.carriers.delhivery.active');
    }

    /**
     * Check if running in sandbox / test mode.
     */
    public function isSandbox(): bool
    {
        return (bool) core()->getConfigData('sales.carriers.delhivery.sandbox');
    }

    /**
     * Get Delhivery API Token.
     */
    public function getApiToken(): ?string
    {
        return core()->getConfigData('sales.carriers.delhivery.api_token');
    }

    /**
     * Check if API token is configured.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->getApiToken());
    }

    /**
     * Get registered client / account name.
     */
    public function getClientId(): string
    {
        return (string) (core()->getConfigData('sales.carriers.delhivery.client_id') ?: 'SOXNSOX');
    }

    /**
     * Get pickup location / warehouse name.
     */
    public function getPickupLocation(): string
    {
        return (string) (core()->getConfigData('sales.carriers.delhivery.pickup_location') ?: 'Primary Warehouse');
    }

    /**
     * Get pickup origin PIN code.
     */
    public function getPickupPincode(): string
    {
        return (string) (core()->getConfigData('sales.carriers.delhivery.pickup_pincode') ?: '500001');
    }

    /**
     * Get default shipping mode (Surface or Express).
     */
    public function getShippingMode(): string
    {
        return (string) (core()->getConfigData('sales.carriers.delhivery.shipping_mode') ?: 'Surface');
    }

    /**
     * Check if auto-generate AWB is enabled upon shipment creation.
     */
    public function isAutoGenerateAwb(): bool
    {
        return (bool) core()->getConfigData('sales.carriers.delhivery.auto_generate_awb');
    }

    /**
     * Get base API endpoint URL depending on mode.
     */
    public function getBaseUrl(): string
    {
        return $this->isSandbox()
            ? 'https://staging-express.delhivery.com'
            : 'https://track.delhivery.com';
    }

    /**
     * Common HTTP request headers.
     */
    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Token '.$this->getApiToken(),
            'Accept' => 'application/json',
        ];
    }

    /**
     * Verify PIN code serviceability via Delhivery API.
     */
    public function checkPincodeServiceability(string $pincode): array
    {
        if (! $this->isConfigured()) {
            return [
                'serviceable' => true,
                'cod' => true,
                'prepaid' => true,
            ];
        }

        $pincode = trim($pincode);
        $cacheKey = 'delhivery_pincode_'.($this->isSandbox() ? 'test_' : 'live_').$pincode;

        return Cache::remember($cacheKey, 86400, function () use ($pincode) {
            try {
                $response = Http::withHeaders($this->getHeaders())
                    ->timeout(8)
                    ->get($this->getBaseUrl().'/c/api/pin-codes/json/', [
                        'filter_codes' => $pincode,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $codes = $data['delivery_codes'] ?? [];

                    foreach ($codes as $item) {
                        $postal = $item['postal_code'] ?? [];
                        if (isset($postal['pin']) && (string) $postal['pin'] === $pincode) {
                            $isPrepaid = strtoupper($postal['pre_paid'] ?? '') === 'Y';
                            $isCod = strtoupper($postal['cod'] ?? '') === 'Y';

                            return [
                                'serviceable' => $isPrepaid || $isCod,
                                'prepaid' => $isPrepaid,
                                'cod' => $isCod,
                                'district' => $postal['district'] ?? null,
                                'state' => $postal['state_code'] ?? null,
                            ];
                        }
                    }
                }
            } catch (Exception $e) {
                Log::warning('Delhivery PIN code check failed for '.$pincode.': '.$e->getMessage());
            }

            // Fallback to serviceable so orders are not blocked on network/API downtime
            return [
                'serviceable' => true,
                'cod' => true,
                'prepaid' => true,
            ];
        });
    }

    /**
     * Calculate live shipping rate estimate from Delhivery.
     */
    public function calculateRate(string $destPincode, float $weightGrams = 200, bool $isCod = false): ?float
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            $mode = $this->getShippingMode() === 'Express' ? 'E' : 'S';
            $destPincode = trim($destPincode);
            $sourcePincode = $this->getPickupPincode();

            $response = Http::withHeaders($this->getHeaders())
                ->timeout(8)
                ->get($this->getBaseUrl().'/api/kinko/v1/invoice/charges/.json', [
                    'md' => $mode,
                    'ss' => $sourcePincode,
                    'ds' => $destPincode,
                    'cgm' => max(100, round($weightGrams)),
                    'cl' => $this->getClientId(),
                    'pt' => $isCod ? 'COD' : 'Pre-paid',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && isset($data[0]['total_amount'])) {
                    return (float) $data[0]['total_amount'];
                }
            }
        } catch (Exception $e) {
            Log::warning('Delhivery rate calculation failed: '.$e->getMessage());
        }

        return null;
    }

    /**
     * Create shipment / B2C manifest on Delhivery One.
     */
    public function createShipment($order, $shipment, array $overrideData = []): array
    {
        if (! $this->isActive()) {
            return [
                'success' => false,
                'message' => 'Delhivery carrier is currently disabled in system settings.',
            ];
        }

        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Delhivery API Token is not configured. Please enter the token in Admin -> Configure -> Sales -> Shipping & Logistics.',
            ];
        }

        $shippingAddress = $order->shipping_address;

        if (! $shippingAddress) {
            return [
                'success' => false,
                'message' => 'Order is missing a valid shipping address.',
            ];
        }

        $isCod = $order->payment && $order->payment->method === 'cashondelivery';
        $weightGrams = max(100, (int) (($shipment->total_weight ?: 0.25) * 1000));

        $productsDesc = [];
        foreach ($shipment->items as $item) {
            $productsDesc[] = ($item->name ?: 'Bamboo Socks').' x '.($item->qty ?: 1);
        }
        $descString = substr(implode(', ', $productsDesc) ?: 'Premium Bamboo Socks', 0, 100);

        $payload = [
            'shipments' => [
                [
                    'name' => $shippingAddress->name,
                    'add' => trim($shippingAddress->address1.' '.($shippingAddress->address2 ?? '')),
                    'pin' => (string) $shippingAddress->postcode,
                    'city' => $shippingAddress->city,
                    'state' => $shippingAddress->state,
                    'country' => $shippingAddress->country ?: 'India',
                    'phone' => preg_replace('/[^0-9]/', '', (string) $shippingAddress->phone),
                    'order' => (string) $order->increment_id,
                    'payment_mode' => $isCod ? 'COD' : 'Prepaid',
                    'return_pin' => $this->getPickupPincode(),
                    'return_city' => '',
                    'return_phone' => '',
                    'return_add' => '',
                    'return_state' => '',
                    'return_country' => '',
                    'products_desc' => $descString,
                    'hsn_code' => '6115',
                    'cod_amount' => $isCod ? (float) $order->grand_total : 0.0,
                    'order_date' => $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                    'total_amount' => (float) $order->grand_total,
                    'seller_add' => '',
                    'seller_name' => $this->getClientId(),
                    'seller_inv' => (string) $order->increment_id,
                    'quantity' => max(1, (int) $shipment->total_qty),
                    'waybill' => $overrideData['waybill'] ?? '',
                    'shipment_width' => 15,
                    'shipment_height' => 5,
                    'shipment_length' => 20,
                    'weight' => $weightGrams,
                    'shipping_mode' => $this->getShippingMode(),
                    'address_type' => 'home',
                ],
            ],
            'pickup_location' => [
                'name' => $this->getPickupLocation(),
            ],
        ];

        try {
            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Token '.$this->getApiToken(),
                    'Accept' => 'application/json',
                ])
                ->timeout(15)
                ->post($this->getBaseUrl().'/api/cmu/create.json', [
                    'format' => 'json',
                    'data' => json_encode($payload),
                ]);

            $result = $response->json();

            Log::info('Delhivery Shipment Creation Response:', ['response' => $result]);

            if ($response->successful() && ! empty($result['packages'][0])) {
                $pkg = $result['packages'][0];

                if (! empty($pkg['status']) && strtolower($pkg['status']) === 'fail') {
                    $errorMsg = ! empty($pkg['remarks']) ? implode(', ', (array) $pkg['remarks']) : 'Delhivery rejected the package.';

                    return [
                        'success' => false,
                        'message' => $errorMsg,
                        'data' => $result,
                    ];
                }

                $waybill = $pkg['waybill'] ?? null;

                if ($waybill) {
                    return [
                        'success' => true,
                        'waybill' => $waybill,
                        'message' => 'Delhivery shipment booked successfully.',
                        'data' => $result,
                    ];
                }
            }

            $errorMessage = $result['rmk'] ?? $result['error'] ?? 'Unexpected response from Delhivery API.';

            return [
                'success' => false,
                'message' => is_array($errorMessage) ? json_encode($errorMessage) : (string) $errorMessage,
                'data' => $result,
            ];
        } catch (Exception $e) {
            Log::error('Delhivery Shipment creation exception: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to connect to Delhivery API: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Get live public package tracking URL.
     */
    public function getTrackingUrl(string $waybill): string
    {
        return 'https://www.delhivery.com/track/package/'.urlencode(trim($waybill));
    }

    /**
     * Download or stream shipping packing slip PDF.
     */
    public function fetchPackingSlipPdf(string $waybill): ?string
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            $response = Http::withHeaders($this->getHeaders())
                ->timeout(15)
                ->get($this->getBaseUrl().'/api/p/packing_slip', [
                    'wbns' => trim($waybill),
                    'pdf' => 'true',
                ]);

            if ($response->successful()) {
                return $response->body();
            }
        } catch (Exception $e) {
            Log::error('Delhivery Packing Slip download failed: '.$e->getMessage());
        }

        return null;
    }
}
