<?php

namespace Webkul\Admin\DataGrids\Settings;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class InventoryAdjustmentDataGrid extends DataGrid
{
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('inventory_adjustments as ia')
            ->leftJoin('inventory_sources as isrc', 'ia.inventory_source_id', '=', 'isrc.id')
            ->select(
                'ia.id',
                'ia.reference_number',
                'ia.type',
                'isrc.name as location_name',
                'ia.status',
                'ia.created_at'
            );

        $this->addFilter('id', 'ia.id');
        $this->addFilter('reference_number', 'ia.reference_number');
        $this->addFilter('type', 'ia.type');
        $this->addFilter('status', 'ia.status');

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
            'index' => 'type',
            'label' => 'Type',
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
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);
    }
}
