<?php

namespace ITBrains\Validation;

use Illuminate\Database\Eloquent\Model;

class Rule extends \Illuminate\Validation\Rule
{
    /**
     * Get a unique constraint builder instance.
     *
     * @param string $modelClass
     * @param  string $column
     * @return \Illuminate\Validation\Rules\Unique
     */
    public static function uniqueModel(string $modelClass, $column = 'NULL')
    {
        /** @var Model $instance */
        $instance = (new $modelClass);

        $uniqueRule = new \Illuminate\Validation\Rules\Unique(self::getConnectionAndTableOfInstance($instance), $column);

        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($modelClass))) {
            $uniqueRule = $uniqueRule->whereNull($instance->getDeletedAtColumn());
        }

        return $uniqueRule;
    }

    /**
     * @param string $modelClass
     * @param string|null $column
     * @return \Illuminate\Validation\Rules\Exists
     */
    public static function existsModel(string $modelClass, string $column = null)
    {
        /** @var Model $instance */
        $instance = new $modelClass;

        $existsRule = static::exists(self::getConnectionAndTableOfInstance($instance), $column ?: $instance->getKeyName());

        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses($modelClass))) {
            $existsRule = $existsRule->whereNull($instance->getDeletedAtColumn());
        }

        return $existsRule;
    }

    protected static function getConnectionAndTableOfInstance(Model $instance): string
    {
        return $instance->getConnectionName() . "." . $instance->getTable();
    }
}
