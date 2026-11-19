<?php

namespace Webkul\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Inventory\Contracts\InventoryMovement as InventoryMovementContract;
use Webkul\Product\Models\ProductProxy;
use Webkul\User\Models\AdminProxy;

class InventoryMovement extends Model implements InventoryMovementContract
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }

    public function inventory_source()
    {
        return $this->belongsTo(InventorySourceProxy::modelClass());
    }

    public function admin()
    {
        return $this->belongsTo(AdminProxy::modelClass(), 'user_id');
    }
}
