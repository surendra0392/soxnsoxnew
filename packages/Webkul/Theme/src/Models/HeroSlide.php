<?php

namespace Webkul\Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Theme\Contracts\HeroSlide as HeroSlideContract;

class HeroSlide extends Model implements HeroSlideContract
{
    protected $table = 'theme_hero_slides';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'settings' => 'array',
        'status' => 'boolean',
        'active_from' => 'datetime',
        'active_to' => 'datetime',
    ];

    public function slider()
    {
        return $this->belongsTo(HeroSliderProxy::modelClass());
    }

    public function layers()
    {
        return $this->hasMany(HeroLayerProxy::modelClass())->orderBy('sort_order', 'asc');
    }
}
