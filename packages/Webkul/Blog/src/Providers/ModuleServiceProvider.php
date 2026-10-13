<?php

namespace Webkul\Blog\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Webkul\Blog\Models\Blog;
use Webkul\Blog\Models\BlogTranslation;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        Blog::class,
        BlogTranslation::class,
    ];
}
