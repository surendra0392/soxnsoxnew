<?php

namespace Webkul\Product\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\Inventory\Models\InventoryMovementProxy;

class ProductInventoryRepository extends Repository
{
    /**
     * Specify Model class name.
     */
    public function model(): string
    {
        return 'Webkul\Product\Contracts\ProductInventory';
    }

    /**
     * @param  Webkul\Product\Contracts\Product  $product
     * @return void
     */
    public function saveInventories(array $data, $product)
    {
        if (! isset($data['inventories'])) {
            return;
        }

        foreach ($data['inventories'] as $inventorySourceId => $qty) {
            $inventory = $this->findOneWhere([
                'product_id' => $product->id,
                'inventory_source_id' => $inventorySourceId,
                'vendor_id' => $data['vendor_id'] ?? 0,
            ]);

            $currentQty = $inventory ? $inventory->qty : 0;
            $diff = ($qty ?? 0) - $currentQty;

            if ($diff != 0) {
                InventoryMovementProxy::modelClass()::create([
                    'product_id' => $product->id,
                    'inventory_source_id' => $inventorySourceId,
                    'quantity' => $diff,
                    'type' => $inventory ? 'adjustment' : 'opening',
                    'reference_type' => 'Manual',
                    'user_id' => auth()->guard('admin')->check() ? auth()->guard('admin')->user()->id : null,
                    'notes' => 'Admin manual update',
                ]);
            }

            $this->updateOrCreate([
                'product_id' => $product->id,
                'inventory_source_id' => $inventorySourceId,
                'vendor_id' => $data['vendor_id'] ?? 0,
            ], [
                'qty' => $qty ?? 0,
            ]);
        }
    }
}
