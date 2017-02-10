<?php

namespace ITBrains\Validation\Contracts;

use Illuminate\Validation\Factory;

interface Validator
{
    /**
     * Method of validation
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator): bool;

    /**
     * Replace all place-holders for the validator rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array $parameters
     * @return string
     */
    public function replace($message, $attribute, $rule, $parameters): string;

    /**
     * Register validator in the system
     *
     * @param Factory $validator
     */
    public static function boot(Factory $validator): void;

}
