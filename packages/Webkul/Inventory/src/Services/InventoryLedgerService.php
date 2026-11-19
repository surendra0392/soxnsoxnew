<?php

namespace Webkul\Inventory\Services;

use Webkul\Inventory\Contracts\InventoryMovement;
use Webkul\Inventory\Models\InventoryMovementProxy;
use Webkul\Product\Repositories\ProductInventoryRepository;

class InventoryLedgerService
{
    public function __construct(
        protected ProductInventoryRepository $productInventoryRepository
    ) {}

    /**
     * Create a stock movement and automatically update the physical stock cache.
     *
     * @param  array  $data
     *                       [
     *                       'product_id' => int,
     *                       'inventory_source_id' => int,
     *                       'quantity' => float, // positive for receipt, negative for issue
     *                       'type' => string,
     *                       'reference_type' => string,
     *                       'reference_id' => int,
     *                       'batch_number' => string,
     *                       'user_id' => int,
     *                       'notes' => string,
     *                       ]
     * @return InventoryMovement
     */
    public function createMovement(array $data)
    {
        if ($data['quantity'] == 0) {
            return null; // Ignore zero movements
        }

        // 1. Create the immutable ledger record
        $movement = InventoryMovementProxy::modelClass()::create($data);

        // 2. Adjust the product_inventories cache table natively
        $inventory = $this->productInventoryRepository->findOneWhere([
            'product_id' => $data['product_id'],
            'inventory_source_id' => $data['inventory_source_id'],
            'vendor_id' => 0,
        ]);

        $currentQty = $inventory ? $inventory->qty : 0;
        $newQty = $currentQty + $data['quantity'];

        $this->productInventoryRepository->updateOrCreate([
            'product_id' => $data['product_id'],
            'inventory_source_id' => $data['inventory_source_id'],
            'vendor_id' => 0, // Bagisto default
        ], [
            'qty' => $newQty,
        ]);

        return $movement;
    }
}
