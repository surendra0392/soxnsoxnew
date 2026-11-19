<?php

namespace Webkul\Admin\DataGrids\Theme;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class HeroSliderDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('theme_hero_sliders')
            ->select('id', 'name', 'code', 'status', 'placement', 'created_at');

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
            'label' => trans('admin::app.theme.hero-sliders.index.datagrid.id'),
            'type' => 'integer',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.theme.hero-sliders.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'code',
            'label' => trans('admin::app.theme.hero-sliders.index.datagrid.code'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'placement',
            'label' => trans('admin::app.theme.hero-sliders.index.datagrid.placement'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.theme.hero-sliders.index.datagrid.status'),
            'type' => 'boolean',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
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
            'title' => trans('admin::app.theme.hero-sliders.index.datagrid.edit'),
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.cms.hero_sliders.edit', $row->id);
            },
        ]);

        $this->addAction([
            'icon' => 'icon-delete',
            'title' => trans('admin::app.theme.hero-sliders.index.datagrid.delete'),
            'method' => 'DELETE',
            'url' => function ($row) {
                return route('admin.cms.hero_sliders.delete', $row->id);
            },
        ]);
    }
}
