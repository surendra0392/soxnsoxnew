<?php

namespace Webkul\Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Theme\Contracts\HeroLayer as HeroLayerContract;

class HeroLayer extends Model implements HeroLayerContract
{
    protected $table = 'theme_hero_layers';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'desktop_settings' => 'array',
        'tablet_settings' => 'array',
        'mobile_settings' => 'array',
        'settings' => 'array',
    ];

    public function slide()
    {
        return $this->belongsTo(HeroSlideProxy::modelClass());
    }
}
