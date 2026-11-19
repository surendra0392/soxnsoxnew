<?php

namespace Webkul\Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Theme\Contracts\HeroSlider as HeroSliderContract;

class HeroSlider extends Model implements HeroSliderContract
{
    protected $table = 'theme_hero_sliders';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'settings' => 'array',
        'status' => 'boolean',
    ];

    public function slides()
    {
        return $this->hasMany(HeroSlideProxy::modelClass())->orderBy('sort_order', 'asc');
    }
}
