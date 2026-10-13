<?php

namespace Webkul\Blog\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Webkul\DataGrid\DataGrid;

class BlogDataGrid extends DataGrid
{
    /**
     * Primary column.
     *
     * @var string
     */
    protected $primaryColumn = 'id';

    /**
     * Prepare query builder.
     *
     * @return Builder
     */
    public function prepareQueryBuilder()
    {
        $currentLocale = app()->getLocale();

        $queryBuilder = DB::table('blogs')
            ->select(
                'blogs.id',
                'blogs.featured_image',
                'blogs.author_name',
                'blogs.read_time',
                'blogs.status',
                'blogs.created_at',
                'blog_translations.name',
                'blog_translations.url_key',
                'blog_translations.category'
            )
            ->leftJoin('blog_translations', function ($leftJoin) use ($currentLocale) {
                $leftJoin->on('blogs.id', '=', 'blog_translations.blog_id')
                    ->where('blog_translations.locale', '=', $currentLocale);
            });

        $this->addFilter('id', 'blogs.id');
        $this->addFilter('name', 'blog_translations.name');
        $this->addFilter('category', 'blog_translations.category');
        $this->addFilter('status', 'blogs.status');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
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
            'index' => 'featured_image',
            'label' => trans('admin::app.datagrid.image'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => false,
            'filterable' => false,
            'closure' => function ($row) {
                if (! empty($row->featured_image)) {
                    $url = filter_var($row->featured_image, FILTER_VALIDATE_URL)
                        ? $row->featured_image
                        : (file_exists(public_path($row->featured_image))
                            ? asset($row->featured_image)
                            : Storage::url($row->featured_image));

                    return '<img src="'.e($url).'" class="w-12 h-12 rounded-lg object-cover border border-slate-200" alt="'.e($row->name ?? 'Blog').'" />';
                }

                return '<div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-semibold">SOX</div>';
            },
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.datagrid.title'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'category',
            'label' => 'Category',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                $category = $row->category ?: 'Foot Care';

                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#2ca7a3]/10 text-[#2ca7a3] border border-[#2ca7a3]/30">'.e($category).'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'author_name',
            'label' => 'Author',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'read_time',
            'label' => 'Read Time',
            'type' => 'integer',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return ($row->read_time ?? 5).' mins';
            },
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.datagrid.status'),
            'type' => 'boolean',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($row) {
                return $row->status
                    ? '<span class="badge badge-md badge-success">'.trans('admin::app.datagrid.active').'</span>'
                    : '<span class="badge badge-md badge-danger">'.trans('admin::app.datagrid.inactive').'</span>';
            },
        ]);

        $this->addColumn([
            'index' => 'created_at',
            'label' => trans('admin::app.datagrid.created-at'),
            'type' => 'date',
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
            'icon' => 'icon-view',
            'title' => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'target' => '_blank',
            'url' => function ($row) {
                return route('shop.blogs.view', [
                    'category_slug' => Str::slug($row->category ?: 'general'),
                    'url_key' => $row->url_key,
                ]);
            },
        ]);

        $this->addAction([
            'icon' => 'icon-edit',
            'title' => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'url' => function ($row) {
                return route('admin.blogs.edit', $row->id);
            },
        ]);

        $this->addAction([
            'icon' => 'icon-delete',
            'title' => trans('admin::app.datagrid.delete'),
            'method' => 'DELETE',
            'url' => function ($row) {
                return route('admin.blogs.destroy', $row->id);
            },
        ]);
    }
}
