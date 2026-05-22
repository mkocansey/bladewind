<?php

namespace Mkocansey\Bladewind\Colorpicker;

use Illuminate\Support\ServiceProvider;

class BladewindColorpickerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bladewind.php', 'bladewind');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bladewind');

        $this->publishes([
            __DIR__.'/../resources/views/components/' => resource_path('views/components/bladewind'),
        ], 'bladewind-components');

        $bladewindPublicPaths = [];
        if (is_dir(__DIR__.'/../resources/assets/css')) {
            $bladewindPublicPaths[__DIR__.'/../resources/assets/css/'] = public_path('vendor/bladewind/css');
        }
        if (is_dir(__DIR__.'/../public')) {
            $bladewindPublicPaths[__DIR__.'/../public/'] = public_path('vendor/bladewind');
        }
        if (!empty($bladewindPublicPaths)) {
            $this->publishes($bladewindPublicPaths, 'bladewind-public');
        }
    }
}
