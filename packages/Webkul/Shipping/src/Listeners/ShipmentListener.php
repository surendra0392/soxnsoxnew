<?php

namespace Webkul\Shipping\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\Sales\Contracts\Shipment;
use Webkul\Shipping\Services\DelhiveryService;

class ShipmentListener
{
    /**
     * Create a new listener instance.
     */
    public function __construct(
        protected DelhiveryService $delhiveryService
    ) {}

    /**
     * Handle the sales.shipment.save.after event.
     *
     * @param  Shipment  $shipment
     * @return void
     */
    public function afterShipmentCreated($shipment)
    {
        if (! $this->delhiveryService->isActive()) {
            return;
        }

        if (! $this->delhiveryService->isConfigured()) {
            return;
        }

        if (! $this->delhiveryService->isAutoGenerateAwb()) {
            return;
        }

        // If tracking number is already populated, skip auto generation
        if (! empty($shipment->track_number)) {
            return;
        }

        $order = $shipment->order;

        if (! $order) {
            return;
        }

        try {
            $result = $this->delhiveryService->createShipment($order, $shipment);

            if (! empty($result['success']) && ! empty($result['waybill'])) {
                $shipment->update([
                    'carrier_title' => $shipment->carrier_title ?: 'Delhivery',
                    'track_number' => $result['waybill'],
                ]);

                Log::info("Delhivery auto-generated AWB {$result['waybill']} for Shipment #{$shipment->id}");
            } else {
                Log::warning("Delhivery auto-generation failed for Shipment #{$shipment->id}: ".($result['message'] ?? 'Unknown error'));
            }
        } catch (\Throwable $e) {
            Log::error("Delhivery listener exception on Shipment #{$shipment->id}: ".$e->getMessage());
        }
    }
}
