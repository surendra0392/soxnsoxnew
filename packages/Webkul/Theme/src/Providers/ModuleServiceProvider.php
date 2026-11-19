<?php

namespace Webkul\Theme\Providers;

use Webkul\Core\Providers\CoreModuleServiceProvider;
use Webkul\Theme\Models\HeroLayer;
use Webkul\Theme\Models\HeroSlide;
use Webkul\Theme\Models\HeroSlider;
use Webkul\Theme\Models\ThemeCustomization;
use Webkul\Theme\Models\ThemeCustomizationTranslation;

class ModuleServiceProvider extends CoreModuleServiceProvider
{
    /**
     * Define the models
     *
     * @var array
     */
    protected $models = [
        ThemeCustomization::class,
        ThemeCustomizationTranslation::class,
        HeroSlider::class,
        HeroSlide::class,
        HeroLayer::class,
    ];
}
