<?php

namespace Sandaffo\LaravelModelValidator;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        // Register model extensions
        $this->app->afterResolving('Illuminate\Database\Eloquent\Model', function ($model) {
            $model->addTrait(ModelExtensions::class);
        });
    }

    public function register()
    {
        // Register any application services.
    }
}
