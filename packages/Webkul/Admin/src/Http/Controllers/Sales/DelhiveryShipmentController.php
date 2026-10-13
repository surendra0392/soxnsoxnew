<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Sales\Repositories\ShipmentRepository;
use Webkul\Shipping\Services\DelhiveryService;

class DelhiveryShipmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected ShipmentRepository $shipmentRepository,
        protected DelhiveryService $delhiveryService
    ) {}

    /**
     * Book / push shipment to Delhivery and assign AWB.
     */
    public function createDelhiveryShipment(int $id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);
        $order = $shipment->order;

        if (! $this->delhiveryService->isActive()) {
            session()->flash('error', 'Delhivery integration is currently disabled. Please enable it in Configuration.');

            return redirect()->back();
        }

        if (! $this->delhiveryService->isConfigured()) {
            session()->flash('error', 'Delhivery API Token is missing. Please configure it in Admin -> Configure -> Sales -> Shipping & Logistics.');

            return redirect()->back();
        }

        $result = $this->delhiveryService->createShipment($order, $shipment);

        if (! empty($result['success']) && ! empty($result['waybill'])) {
            $shipment->update([
                'carrier_title' => 'Delhivery',
                'track_number' => $result['waybill'],
            ]);

            session()->flash('success', "Delhivery shipment booked successfully! AWB: {$result['waybill']}");
        } else {
            session()->flash('error', 'Delhivery Error: '.($result['message'] ?? 'Could not generate shipment.'));
        }

        return redirect()->back();
    }

    /**
     * Download or stream Delhivery shipping packing label.
     */
    public function downloadLabel(int $id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);

        if (empty($shipment->track_number)) {
            session()->flash('error', 'No tracking number / AWB found for this shipment.');

            return redirect()->back();
        }

        $pdfContent = $this->delhiveryService->fetchPackingSlipPdf($shipment->track_number);

        if ($pdfContent) {
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="delhivery-label-'.$shipment->track_number.'.pdf"',
            ]);
        }

        return redirect()->away(
            $this->delhiveryService->getBaseUrl().'/api/p/packing_slip?wbns='.urlencode($shipment->track_number).'&pdf=true'
        );
    }

    /**
     * Live track parcel on Delhivery.
     */
    public function track(int $id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);

        if (empty($shipment->track_number)) {
            session()->flash('error', 'No tracking number / AWB found for this shipment.');

            return redirect()->back();
        }

        return redirect()->away($this->delhiveryService->getTrackingUrl($shipment->track_number));
    }
}
