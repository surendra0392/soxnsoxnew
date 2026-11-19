<?php

namespace Webkul\Admin\DataGrids\Settings;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ShippingZoneDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('shipping_zones')->select('id', 'name', 'is_active');

        $this->addFilter('id', 'shipping_zones.id');
        $this->addFilter('name', 'shipping_zones.name');
        $this->addFilter('is_active', 'shipping_zones.is_active');

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
            'label' => 'ID',
            'type' => 'integer',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => 'Zone Name',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'is_active',
            'label' => 'Status',
            'type' => 'boolean',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                if ($row->is_active) {
                    return '<span class="badge badge-md badge-success">Active</span>';
                }

                return '<span class="badge badge-md badge-danger">Inactive</span>';
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
            'icon' => 'icon-edit',
            'title' => 'Edit',
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.settings.shipping.zones.edit', $row->id);
            },
        ]);

        $this->addAction([
            'icon' => 'icon-delete',
            'title' => 'Delete',
            'method' => 'DELETE',
            'url' => function ($row) {
                return route('admin.settings.shipping.zones.delete', $row->id);
            },
        ]);
    }
}
