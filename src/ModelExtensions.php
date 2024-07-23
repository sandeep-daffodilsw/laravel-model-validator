<?php

namespace SandeepDaffodil\LaravelModelValidator;

use Illuminate\Support\Facades\Validator;

trait ModelExtensions
{
    protected static $rules = [];
    protected static $messages = [];

    public static function bootModelExtensions()
    {
        static::saving(function ($model) {
            $validator = Validator::make($model->attributesToArray(), static::$rules, static::$messages);

            if ($validator->fails()) {
                throw new \Illuminate\Validation\ValidationException($validator);
            }
        });
    }

    public function isValid()
    {
        $validator = Validator::make($this->attributesToArray(), static::$rules, static::$messages);
        return !$validator->fails();
    }

    public function errors()
    {
        $validator = Validator::make($this->attributesToArray(), static::$rules, static::$messages);
        return $validator->errors()->messages();
    }

    public function errorMessages()
    {
        return array_values($this->errors());
    }
}
