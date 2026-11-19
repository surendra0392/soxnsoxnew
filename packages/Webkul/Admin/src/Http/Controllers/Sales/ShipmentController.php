<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use Illuminate\Http\Response;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Sales\OrderShipmentDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Traits\PDFHandler;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;

class ShipmentController extends Controller
{
    use PDFHandler;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected ShipmentRepository $shipmentRepository
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(OrderShipmentDataGrid::class)->process();
        }

        return view('admin::sales.shipments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(int $orderId)
    {
        $order = $this->orderRepository->findOrFail($orderId);

        if (! $order->channel || ! $order->canShip()) {
            session()->flash('error', trans('admin::app.sales.shipments.create.creation-error'));

            return redirect()->back();
        }

        return view('admin::sales.shipments.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(int $orderId)
    {
        $order = $this->orderRepository->findOrFail($orderId);

        if (! $order->canShip()) {
            session()->flash('error', trans('admin::app.sales.shipments.create.order-error'));

            return redirect()->back();
        }

        $this->validate(request(), [
            'shipment.source' => 'required|integer|exists:inventory_sources,id',
            'shipment.items' => 'required|array',
            'shipment.items.*.*' => 'required|numeric|min:0',
            'shipment.carrier_title' => 'nullable|string|max:255',
            'shipment.track_number' => 'nullable|string|max:255',
        ]);

        $data = request()->only(['shipment', 'carrier_name']);

        if (! $this->isInventoryValidate($data, (int) $orderId)) {
            session()->flash('error', trans('admin::app.sales.shipments.create.quantity-invalid'));

            return redirect()->back();
        }

        $this->shipmentRepository->create(array_merge($data, [
            'order_id' => $orderId,
        ]));

        session()->flash('success', trans('admin::app.sales.shipments.create.success'));

        return redirect()->route('admin.sales.orders.view', $orderId);
    }

    /**
     * Checks if requested quantity available or not.
     *
     * @param  array  $data
     * @return bool
     */
    public function isInventoryValidate(&$data, ?int $orderId = null)
    {
        if (! isset($data['shipment']['items']) || ! is_array($data['shipment']['items'])) {
            return false;
        }

        $valid = false;

        $inventorySourceId = $data['shipment']['source'];

        foreach ($data['shipment']['items'] as $itemId => $inventorySource) {
            if (! is_array($inventorySource) || ! array_key_exists($inventorySourceId, $inventorySource)) {
                continue;
            }

            $qty = $inventorySource[$inventorySourceId];

            if ((int) $qty) {
                $criteria = ['id' => $itemId];

                if ($orderId !== null) {
                    $criteria['order_id'] = $orderId;
                }

                $orderItem = $this->orderItemRepository->findOneWhere($criteria);

                if (! $orderItem || $orderItem->qty_to_ship < $qty) {
                    return false;
                }

                if ($orderItem->getTypeInstance()->isComposite()) {
                    foreach ($orderItem->children as $child) {
                        if (! $child->qty_ordered) {
                            continue;
                        }

                        if (! $child->product) {
                            return false;
                        }

                        $finalQty = ($child->qty_ordered / $orderItem->qty_ordered) * $qty;

                        $availableQty = $child->product->inventories()
                            ->where('inventory_source_id', $inventorySourceId)
                            ->sum('qty');

                        if (
                            $child->qty_to_ship < $finalQty
                            || $availableQty < $finalQty
                        ) {
                            return false;
                        }
                    }
                } else {
                    if (! $orderItem->product) {
                        return false;
                    }

                    $availableQty = $orderItem->product->inventories()
                        ->where('inventory_source_id', $inventorySourceId)
                        ->sum('qty');

                    if (
                        $orderItem->qty_to_ship < $qty
                        || $availableQty < $qty
                    ) {
                        return false;
                    }
                }

                $valid = true;
            } else {
                unset($data['shipment']['items'][$itemId]);
            }
        }

        return $valid;
    }

    /**
     * Show the view for the specified resource.
     *
     * @return View
     */
    public function view(int $id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);

        return view('admin::sales.shipments.view', compact('shipment'));
    }

    /**
     * Print and download the packing slip for the specified resource.
     *
     * @return Response
     */
    public function printPackingSlip(int $id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);

        $order = $shipment->order;

        return $this->downloadPDF(
            view('admin::sales.shipments.pdf', compact('shipment', 'order'))->render(),
            'packing-slip-'.$shipment->id.'-'.$shipment->created_at->format('d-m-Y')
        );
    }

    /**
     * Print and download the delivery slip / proof of delivery for the specified resource.
     *
     * @return Response
     */
    public function printDeliverySlip(int $id)
    {
        $shipment = $this->shipmentRepository->findOrFail($id);

        $order = $shipment->order;

        return $this->downloadPDF(
            view('admin::sales.shipments.delivery-slip', compact('shipment', 'order'))->render(),
            'delivery-slip-'.$shipment->id.'-'.$shipment->created_at->format('d-m-Y')
        );
    }
}
