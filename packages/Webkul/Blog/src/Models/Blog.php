<?php

namespace Webkul\Blog\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Webkul\Blog\Contracts\Blog as BlogContract;
use Webkul\Product\Models\ProductProxy;

class Blog extends Model implements BlogContract, TranslatableContract
{
    use Translatable;

    protected $fillable = [
        'status',
        'featured_image',
        'author_name',
        'author_title',
        'read_time',
        'published_at',
    ];

    protected $casts = [
        'status' => 'boolean',
        'read_time' => 'integer',
        'published_at' => 'datetime',
    ];

    public $translatedAttributes = [
        'name',
        'url_key',
        'short_description',
        'content',
        'category',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Get the products associated with the blog post.
     */
    public function products()
    {
        return $this->belongsToMany(ProductProxy::modelClass(), 'blog_products');
    }
}
