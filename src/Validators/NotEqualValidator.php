<?php

namespace ITBrains\Validation\Validators;

use ITBrains\Validation\Validator;

class NotEqualValidator extends Validator
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
    public function validate($attribute, $value, $parameters, $validator): bool
    {
        if (! array_key_exists($parameters[0], $validator->getData())) {
            return true;
        }

        return $validator->getData()[$parameters[0]] !== $value;
    }

    /**
     * Replace all place-holders for the validator rule.
     *
     * @param  string $message
     * @param  string $attribute
     * @param  string $rule
     * @param  array $parameters
     * @return string
     */
    public function replace($message, $attribute, $rule, $parameters): string
    {
        return "Field $attribute must be not equal $parameters[0]";
    }
}