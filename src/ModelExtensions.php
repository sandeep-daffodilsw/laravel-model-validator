<?php

namespace Sandaffo\LaravelModelValidator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;

class ModelExtensions
{
    public static function boot()
    {
        Model::macro('validate', function () {
            $rules = $this->getValidationRules();
            $messages = $this->getValidationMessages();

            $validator = Validator::make($this->attributes, $rules, $messages);

            if ($validator->fails()) {
                $this->validationErrors = $validator->errors()->messages();
            } else {
                $this->validationErrors = [];
            }

            return $validator;
        });

        Model::macro('isValid', function () {
            return empty($this->validationErrors);
        });

        Model::macro('errors', function () {
            return $this->validationErrors ?? [];
        });

        Model::macro('errorMessages', function () {
            $messages = [];
            foreach ($this->errors() as $field => $errors) {
                foreach ($errors as $error) {
                    $messages[$field][] = $error;
                }
            }
            return $messages;
        });

        Model::macro('getValidationRules', function () {
            return isset(static::$rules) ? static::$rules : [];
        });

        Model::macro('getValidationMessages', function () {
            return isset(static::$messages) ? static::$messages : [];
        });
    }
}
