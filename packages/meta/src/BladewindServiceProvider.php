<?php

namespace Mkocansey\Bladewind;

use Illuminate\Support\ServiceProvider;

/**
 * Meta service provider for the mkocansey/bladewind full-install package.
 * Publishes the combined config and the compiled CSS bundle.
 */
class BladewindServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bladewind.php', 'bladewind');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/bladewind.php' => config_path('bladewind.php'),
        ], 'bladewind-config');

        // The compiled CSS/JS bundle is published via the individual packages'
        // bladewind-public tag. The meta package itself has no additional assets.
    }
}
