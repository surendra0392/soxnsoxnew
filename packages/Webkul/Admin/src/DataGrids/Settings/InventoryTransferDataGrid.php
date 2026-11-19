<?php

namespace Webkul\Admin\DataGrids\Settings;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class InventoryTransferDataGrid extends DataGrid
{
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('inventory_transfers as it')
            ->leftJoin('inventory_sources as s_src', 'it.source_location_id', '=', 's_src.id')
            ->leftJoin('inventory_sources as d_src', 'it.destination_location_id', '=', 'd_src.id')
            ->select(
                'it.id',
                'it.reference_number',
                's_src.name as source_location',
                'd_src.name as destination_location',
                'it.status',
                'it.created_at'
            );

        $this->addFilter('id', 'it.id');
        $this->addFilter('reference_number', 'it.reference_number');
        $this->addFilter('status', 'it.status');

        return $queryBuilder;
    }

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
            'index' => 'reference_number',
            'label' => 'Reference',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index' => 'source_location',
            'label' => 'Source',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index' => 'destination_location',
            'label' => 'Destination',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return '<span class="badge badge-sm badge-success">'.strtoupper($row->status).'</span>';
            },
        ]);
    }
}
