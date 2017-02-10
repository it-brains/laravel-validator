<?php

namespace ITBrains\Validation;

use ITBrains\Validation\Contracts\Validator as ValidatorContract;
use Illuminate\Validation\Factory;
use ReflectionClass;

abstract class Validator implements ValidatorContract
{
    /**
     * @return string
     */
    protected static function getValidationRuleName(): string
    {
        $reflection = new ReflectionClass(get_called_class());

        $shortClassName = $reflection->getShortName();

        $ruleName = remove_phrase_in_the_end($shortClassName, 'Validator');

        return camel_case_to_underscore($ruleName);
    }

    /**
     * @param Factory $validator
     */
    final public static function boot(Factory $validator): void
    {
        $name = self::getValidationRuleName();

        $className = get_called_class();

        $validator->extend($name, "{$className}@validate");
        $validator->replacer($name, "{$className}@replace");
    }
}
