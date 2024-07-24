<?php

namespace Sandaffo\LaravelModelValidator;

use Illuminate\Support\Facades\Validator;

class ModelExtensions
{
    public static function isValid($model)
    {
        $validator = self::getValidator($model);
        return !$validator->fails();
    }

    public static function errors($model)
    {
        $validator = self::getValidator($model);
        return $validator->fails() ? $validator->errors()->toArray() : [];
    }

    public static function errorMessages($model)
    {
        $validator = self::getValidator($model);
        return $validator->fails() ? $validator->errors()->all() : [];
    }

    public static function getRules($model)
    {
        return property_exists($model, 'rules') ? $model::$rules : [];
    }

    public static function getMessages($model)
    {
        return property_exists($model, 'messages') ? $model::$messages : [];
    }

    public static function getValidator($model)
    {
        $rules = self::getRules($model);

        // Modify unique rules if the model exists (i.e., it's an update)
        if ($model->exists) {
            foreach ($rules as $field => $rule) {
                if (str_contains($rule, 'unique')) {
                    $table = $model->getTable();
                    $id = $model->getKey();
                    $rules[$field] = preg_replace(
                        '/unique:\S+/', // Replace the unique rule with an updated rule
                        'unique:' . $table . ',' . $field . ',' . $id,
                        $rule
                    );
                }
            }
        }

        return Validator::make($model->attributesToArray(), $rules, self::getMessages($model));
    }
}
