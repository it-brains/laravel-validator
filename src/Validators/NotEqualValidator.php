<?php

namespace ITBrains\Validation\Validators;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ITBrains\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

class NotEqualValidator extends Validator
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * NotEqualValidator constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

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
        return $this->getMessage($message, $attribute, $rule, $parameters);
    }

    /**
     * Get the validation message for an attribute and rule.
     *
     * @param $messageFromRequest
     * @param  string $attribute
     * @param  string $rule
     * @param $parameters
     * @return string
     */
    protected function getMessage($messageFromRequest, $attribute, $rule, $parameters)
    {
        $lowerRule = Str::snake($rule);

        if ("validation.{$lowerRule}" !== $messageFromRequest) {
            return $messageFromRequest;
        }

        $customKey = "validation.custom.{$attribute}.{$lowerRule}";

        $customMessage = $this->getCustomMessageFromTranslator($customKey);

        // First we check for a custom defined validation message for the attribute
        // and rule. This allows the developer to specify specific messages for
        // only some attributes and rules that need to get specially formed.
        if ($customMessage !== $customKey) {
            return $customMessage;
        }

        // Finally, if no developer specified messages have been set, and no other
        // special messages apply for this rule, we will just pull the default
        // messages out of the translator service for this validation rule.
        $key = "validation.{$lowerRule}";

        if ($key != ($value = $this->translator->trans($key))) {
            return $value;
        }

        return "Field $attribute must be not equal $parameters[0]";
    }

    /**
     * Get the custom error message from translator.
     *
     * @param  string  $customKey
     * @return string
     */
    protected function getCustomMessageFromTranslator($customKey)
    {
        if (($message = $this->translator->trans($customKey)) !== $customKey) {
            return $message;
        }

        $shortKey = preg_replace('/^validation\.custom\./', '', $customKey);

        $customMessages = Arr::dot(
            (array) $this->translator->trans('validation.custom')
        );

        foreach ($customMessages as $key => $message) {
            if (Str::contains($key, ['*']) && Str::is($key, $shortKey)) {
                return $message;
            }
        }

        return $customKey;
    }
}