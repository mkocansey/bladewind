<?php

namespace Mkocansey\Bladewind\Button;

use Illuminate\Support\ServiceProvider;

class BladewindButtonServiceProvider extends ServiceProvider
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

        $this->publishes([
            __DIR__.'/../resources/assets/css/button.css' => public_path('vendor/bladewind/css/button.css'),
        ], 'bladewind-public');
    }
}
