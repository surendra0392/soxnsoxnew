<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Blog\Contracts\BlogTranslation as BlogTranslationContract;

class BlogTranslation extends Model implements BlogTranslationContract
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'url_key',
        'short_description',
        'content',
        'category',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
