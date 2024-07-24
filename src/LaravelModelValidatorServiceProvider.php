<?php

namespace Sandaffo\LaravelModelValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LaravelModelValidatorServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Adding the methods directly to the Model class via macros
        Builder::macro('isValid', function () {
            return ModelExtensions::isValid($this->getModel());
        });

        Builder::macro('errors', function () {
            return ModelExtensions::errors($this->getModel());
        });

        Builder::macro('errorMessages', function () {
            return ModelExtensions::errorMessages($this->getModel());
        });

        Builder::macro('getRules', function () {
            return ModelExtensions::getRules($this->getModel());
        });

        Builder::macro('getMessages', function () {
            return ModelExtensions::getMessages($this->getModel());
        });

        Builder::macro('getValidator', function () {
            return ModelExtensions::getValidator($this->getModel());
        });
    }
}
