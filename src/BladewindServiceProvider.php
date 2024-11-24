<?php

namespace Mkocansey\Bladewind;

use Illuminate\Support\ServiceProvider;

class BladewindServiceProvider extends ServiceProvider
{
    public function boot()
    {
        require_once __DIR__.'/../src/BladewindHelpers.php';
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'bladewind');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bladewind');

        $this->publishes([
            __DIR__.'/../resources/views/components/' => resource_path('views/components/bladewind'),
        ], 'bladewind-components');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/bladewind/assets'),
        ], 'bladewind-assets');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/bladewind'),
        ], 'bladewind-public');

        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/bladewind'),
        ], 'bladewind-lang');

        $this->publishes([
            __DIR__.'/../config/bladewind.php' => config_path('bladewind.php'),
        ], 'bladewind-config');
    }
}
