<?php

namespace Sandaffo\LaravelModelValidator;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        ModelExtensions::boot();
    }

    public function register()
    {
        // Register any application services.
    }
}
