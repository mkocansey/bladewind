<?php

namespace Mkocansey\Bladewind\Core;

use Illuminate\Support\ServiceProvider;

class BladewindCoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'bladewind');

        $this->publishes([
            __DIR__.'/../lang' => lang_path('vendor/bladewind'),
        ], 'bladewind-lang');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/bladewind'),
        ], 'bladewind-public');
    }
}
