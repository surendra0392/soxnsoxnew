<?php

namespace Webkul\Sales\Repositories;

use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;
use Webkul\Inventory\Models\InventoryMovementProxy;

class ShipmentItemRepository extends Repository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return 'Webkul\Sales\Contracts\ShipmentItem';
    }

    /**
     * @param  array  $data
     * @return void
     */
    public function updateProductInventory($data)
    {
        if (! $data['product']) {
            return;
        }

        if (! $data['product']->manage_stock) {
            return;
        }

        $orderedInventory = $data['product']->ordered_inventories()
            ->where('channel_id', $data['shipment']->order->channel->id)
            ->first();

        if ($orderedInventory) {
            if (($orderedQty = $orderedInventory->qty - $data['qty']) < 0) {
                $orderedQty = 0;
            }

            $orderedInventory->update(['qty' => $orderedQty]);
        }

        $inventory = $data['product']->inventories()
            ->where('vendor_id', $data['vendor_id'])
            ->where('inventory_source_id', $data['shipment']->inventory_source_id)
            ->first();

        if (! $inventory) {
            return;
        }

        $movementQty = -1 * $data['qty'];
        if (($qty = $inventory->qty - $data['qty']) < 0) {
            $movementQty = -1 * $inventory->qty; // Only deduct what we have
            $qty = 0;
        }

        if ($movementQty != 0) {
            InventoryMovementProxy::modelClass()::create([
                'product_id' => $data['product']->id,
                'inventory_source_id' => $data['shipment']->inventory_source_id,
                'quantity' => $movementQty,
                'type' => 'issue',
                'reference_type' => 'Shipment',
                'reference_id' => $data['shipment']->id,
                'user_id' => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->id : null,
                'notes' => 'Shipment created',
            ]);
        }

        $inventory->update(['qty' => $qty]);

        Event::dispatch('catalog.product.update.after', $data['product']);
    }
}
