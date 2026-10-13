<?php

namespace Webkul\Admin\DataGrids\Catalog;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class CategoryDataGrid extends DataGrid
{
    /**
     * Index.
     *
     * @var string
     */
    protected $primaryColumn = 'category_id';

    /**
     * Default sort column.
     *
     * @var string
     */
    protected $sortColumn = 'categories._lft';

    /**
     * Default sort order.
     *
     * @var string
     */
    protected $sortOrder = 'asc';

    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('categories')
            ->select(
                'categories.id as category_id',
                'category_translations.name',
                'categories.parent_id',
                'parent_translations.name as parent_name',
                'categories.position',
                'categories.status',
                'category_translations.locale',
                'categories._lft',
            )
            ->leftJoin('category_translations', function ($join) {
                $join->on('categories.id', '=', 'category_translations.category_id')
                    ->where('category_translations.locale', '=', app()->getLocale());
            })
            ->leftJoin('categories as parent_categories', 'categories.parent_id', '=', 'parent_categories.id')
            ->leftJoin('category_translations as parent_translations', function ($join) {
                $join->on('parent_categories.id', '=', 'parent_translations.category_id')
                    ->where('parent_translations.locale', '=', app()->getLocale());
            })
            ->where('category_translations.locale', app()->getLocale())
            ->groupBy('categories.id');

        $this->addFilter('category_id', 'categories.id');
        $this->addFilter('name', 'category_translations.name');
        $this->addFilter('parent_name', 'parent_translations.name');

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
            'index' => 'category_id',
            'label' => trans('admin::app.catalog.categories.index.datagrid.id'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.catalog.categories.index.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                if (empty($row->parent_id)) {
                    return '<div class="flex items-center gap-2 font-semibold text-gray-900"><span>'.$row->name.'</span> <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-semibold text-slate-600">Root Category</span></div>';
                }

                if ($row->parent_id == 1) {
                    return '<div class="flex items-center gap-2.5 font-semibold text-gray-900"><span class="h-2 w-2 rounded-full bg-[#133b63]"></span><span>'.$row->name.'</span></div>';
                }

                return '<div class="flex items-center gap-2 pl-4 text-gray-700"><span class="text-slate-400 font-bold select-none text-sm">&#x21B3;</span><span class="font-medium text-gray-800">'.$row->name.'</span><span class="inline-flex items-center rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-medium text-slate-500">Subcategory</span></div>';
            },
        ]);

        $this->addColumn([
            'index' => 'parent_name',
            'label' => trans('admin::app.catalog.categories.create.parent-category'),
            'type' => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable' => true,
            'closure' => function ($row) {
                if (empty($row->parent_id)) {
                    return '<span class="text-xs text-gray-400 italic">—</span>';
                }

                if ($row->parent_id == 1) {
                    return '<span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700 border border-blue-200">Main Category</span>';
                }

                return '<span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 border border-emerald-200">'.($row->parent_name ?? 'Medical Socks').'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'position',
            'label' => trans('admin::app.catalog.categories.index.datagrid.position'),
            'type' => 'integer',
            'filterable' => true,
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.catalog.categories.index.datagrid.status'),
            'type' => 'boolean',
            'filterable' => true,
            'filterable_options' => [
                [
                    'label' => trans('admin::app.catalog.categories.index.datagrid.active'),
                    'value' => 1,
                ],
                [
                    'label' => trans('admin::app.catalog.categories.index.datagrid.inactive'),
                    'value' => 0,
                ],
            ],
            'sortable' => true,
            'closure' => function ($value) {
                if ($value->status) {
                    return '<span class="badge badge-md badge-success">'.trans('admin::app.catalog.categories.index.datagrid.active').'</span>';
                }

                return '<span class="badge badge-md badge-danger">'.trans('admin::app.catalog.categories.index.datagrid.inactive').'</span>';
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
        if (bouncer()->hasPermission('catalog.categories.edit')) {
            $this->addAction([
                'icon' => 'icon-edit',
                'title' => trans('admin::app.catalog.categories.index.datagrid.edit'),
                'method' => 'GET',
                'url' => function ($row) {
                    return route('admin.catalog.categories.edit', $row->category_id);
                },
            ]);
        }

        if (bouncer()->hasPermission('catalog.categories.delete')) {
            $this->addAction([
                'icon' => 'icon-delete',
                'title' => trans('admin::app.catalog.categories.index.datagrid.delete'),
                'method' => 'DELETE',
                'url' => function ($row) {
                    return route('admin.catalog.categories.delete', $row->category_id);
                },
            ]);
        }

        if (bouncer()->hasPermission('catalog.categories.delete')) {
            $this->addMassAction([
                'title' => trans('admin::app.catalog.categories.index.datagrid.delete'),
                'method' => 'POST',
                'url' => route('admin.catalog.categories.mass_delete'),
            ]);
        }

        if (bouncer()->hasPermission('catalog.categories.edit')) {
            $this->addMassAction([
                'title' => trans('admin::app.catalog.categories.index.datagrid.update-status'),
                'method' => 'POST',
                'url' => route('admin.catalog.categories.mass_update'),
                'options' => [
                    [
                        'label' => trans('admin::app.catalog.categories.index.datagrid.active'),
                        'value' => 1,
                    ], [
                        'label' => trans('admin::app.catalog.categories.index.datagrid.inactive'),
                        'value' => 0,
                    ],
                ],
            ]);
        }
    }
}
