<?php

namespace Mkocansey\Bladewind;

use Illuminate\Support\ServiceProvider;

class BladewindServiceProvider extends ServiceProvider
{
  public function register(){}

  public function boot()
  {
    $this->loadTranslationsFrom(__DIR__.'/lang', 'bladewind');
    
    $this->loadViewsFrom(__DIR__.'/resources/views', 'bladewind');

    $this->publishes([
        __DIR__.'/resources/views/components/' => resource_path('views/components/bladewind'),
        __DIR__.'/resources/lang' => function_exists('lang_path') ? lang_path() : resource_path('lang'),
        __DIR__.'/resources/assets/compiled' => public_path('bladewind'),
    ], 'assets');

    $this->publishes([
        __DIR__.'/resources/assets/raw' => resource_path('bladewind'),
    ], 'raw-css');
  }
}