<?php

namespace Webkul\Shop\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\Sales\Models\Order;

class OrderDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('orders')
            ->addSelect(
                'orders.id',
                'orders.increment_id',
                'orders.status',
                'orders.operational_status',
                'orders.created_at',
                'orders.grand_total',
                'orders.order_currency_code'
            )
            ->where('orders.customer_id', auth()->guard('customer')->user()->id);

        $this->addFilter('increment_id', 'orders.increment_id');
        $this->addFilter('created_at', 'orders.created_at');
        $this->addFilter('status', 'orders.status');

        return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index' => 'increment_id',
            'label' => trans('shop::app.customers.account.orders.order-id'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('shop::app.customers.account.orders.order-date'),
            'type' => 'date',
            'searchable' => true,
            'filterable' => true,
            'filterable_type' => 'date_range',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'grand_total',
            'label' => trans('shop::app.customers.account.orders.total'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                return core()->formatPrice($row->grand_total, $row->order_currency_code);
            },
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('shop::app.customers.account.orders.status.title'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                if ($row->operational_status) {
                    $badgeClass = in_array($row->operational_status, ['SHIPPED', 'DELIVERED']) ? 'label-active' : 'label-processing';

                    return '<p class="'.$badgeClass.'">'.ucwords(strtolower($row->operational_status)).'</p>';
                }

                switch ($row->status) {
                    case Order::STATUS_PROCESSING:
                        return '<p class="label-processing">'.trans('shop::app.customers.account.orders.status.options.processing').'</p>';

                    case Order::STATUS_COMPLETED:
                        return '<p class="label-active">'.trans('shop::app.customers.account.orders.status.options.completed').'</p>';

                    case Order::STATUS_CANCELED:
                        return '<p class="label-canceled">'.trans('shop::app.customers.account.orders.status.options.canceled').'</p>';

                    case Order::STATUS_CLOSED:
                        return '<p class="label-closed">'.trans('shop::app.customers.account.orders.status.options.closed').'</p>';

                    case Order::STATUS_PENDING:
                        return '<p class="label-pending">'.trans('shop::app.customers.account.orders.status.options.pending').'</p>';

                    case Order::STATUS_PENDING_PAYMENT:
                        return '<p class="label-pending">'.trans('shop::app.customers.account.orders.status.options.pending-payment').'</p>';

                    case Order::STATUS_FRAUD:
                        return '<p class="label-canceled">'.trans('shop::app.customers.account.orders.status.options.fraud').'</p>';
                }
            },
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'icon' => 'icon-eye',
            'title' => trans('shop::app.customers.account.orders.action-view'),
            'method' => 'GET',
            'url' => function ($row) {
                return route('shop.customers.account.orders.view', $row->id);
            },
        ]);
    }
}
