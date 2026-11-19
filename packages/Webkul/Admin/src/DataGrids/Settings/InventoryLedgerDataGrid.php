<?php

namespace Webkul\Admin\DataGrids\Settings;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class InventoryLedgerDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('inventory_movements as im')
            ->leftJoin('products as p', 'im.product_id', '=', 'p.id')
            ->leftJoin('product_flat as pf', function ($join) {
                $join->on('p.id', '=', 'pf.product_id')
                    ->where('pf.locale', app()->getLocale())
                    ->where('pf.channel', core()->getCurrentChannelCode());
            })
            ->leftJoin('inventory_sources as isrc', 'im.inventory_source_id', '=', 'isrc.id')
            ->leftJoin('admins as a', 'im.user_id', '=', 'a.id')
            ->select(
                'im.id',
                'im.product_id',
                'pf.name as product_name',
                'p.sku',
                'isrc.name as location_name',
                'im.quantity',
                'im.type',
                'im.reference_type',
                'im.reference_id',
                'im.notes',
                'a.name as admin_name',
                'im.created_at'
            );

        $this->addFilter('id', 'im.id');
        $this->addFilter('product_name', 'pf.name');
        $this->addFilter('sku', 'p.sku');
        $this->addFilter('location_name', 'isrc.name');
        $this->addFilter('type', 'im.type');
        $this->addFilter('reference_type', 'im.reference_type');
        $this->addFilter('created_at', 'im.created_at');

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
            'index' => 'id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'integer',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'product_name',
            'label' => 'Product',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'sku',
            'label' => trans('admin::app.datagrid.sku'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'location_name',
            'label' => 'Location',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'quantity',
            'label' => 'Qty',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                if ($row->quantity > 0) {
                    return '<span class="badge badge-sm badge-success">+'.$row->quantity.'</span>';
                }

                return '<span class="badge badge-sm badge-danger">'.$row->quantity.'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'type',
            'label' => 'Type',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return '<span class="badge badge-sm badge-info">'.strtoupper($row->type).'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'reference_type',
            'label' => 'Reference',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                if ($row->reference_type) {
                    return $row->reference_type.' #'.$row->reference_id;
                }

                return 'N/A';
            },
        ]);

        $this->addColumn([
            'index' => 'admin_name',
            'label' => 'Admin',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => 'Date',
            'type' => 'datetime',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);
    }
}
