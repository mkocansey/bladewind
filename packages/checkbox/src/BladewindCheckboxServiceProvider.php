<?php

namespace Mkocansey\Bladewind\Checkbox;

use Illuminate\Support\ServiceProvider;

class BladewindCheckboxServiceProvider extends ServiceProvider
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
    }
}
