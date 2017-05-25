<?php

use Illuminate\Support\Str;

class Helper
{
    /**
     * @var string
     */
    protected static $validationAttributePath = "validation.attributes";

    /**
     * @param string $path
     */
    public static function setValidationAttributePath(string $path)
    {
        static::$validationAttributePath = $path;
    }

    /**
     * @param string $name
     * @param array $objectAttributes
     * @param string $message
     * @param string $filedKey
     * @return array
     */
    public static function buildObjectAttributes(
        string $name,
        array $objectAttributes,
        string $message,
        string $filedKey = 'field'
    ): array
    {
        $attributes = [];

        foreach ($objectAttributes as $objectAttribute) {
            $translatedAttribute = static::getAttribute($objectAttribute);

            $validationMessage = static::multiReplace($filedKey, $translatedAttribute, $message);

            $attributes["$name.{$objectAttribute}"] = $validationMessage;
        }

        return $attributes;
    }

    /**
     * @param string $name
     * @param array $arrayAttributes
     * @param string $message
     * @param int|null $count
     * @param string $fieldKey
     * @param string $indexKey
     * @return array
     */
    public static function buildArrayAttributes(
        string $name,
        array $arrayAttributes,
        string $message,
        int $count = null,
        string $fieldKey = 'field',
        string $indexKey = 'index'
    ): array
    {
        $numbers = trans('it-brains::validator.numbers');
        if ($count) {
            $numbers = array_slice($numbers, 0, $count);
        }

        $attributes = [];

        foreach ($numbers as $number => $numberString) {
            foreach ($arrayAttributes as $arrayAttribute) {
                $translatedAttribute = static::getAttribute($arrayAttribute);

                $validationMessage = static::multiReplace($fieldKey, $translatedAttribute, $message);
                $validationMessage = static::multiReplace($indexKey, $numberString, $validationMessage);

                $attributes["$name.{$number}.{$arrayAttribute}"] = $validationMessage;
            }
        }

        return $attributes;
    }

    /**
     * @param string $attribute
     * @return string
     */
    protected static function getAttribute(string $attribute): string
    {
        $validationPath = static::$validationAttributePath;

        $translationKey = "{$validationPath}.{$attribute}";
        $translatedAttribute = trans("{$validationPath}.{$attribute}");

        if ($translationKey === $translatedAttribute) {
            $translatedAttribute = str_replace("_", " ", $attribute);
        }

        return $translatedAttribute;
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $phrase
     * @return string
     */
    protected static function multiReplace(string $field, string $value, string $phrase): string
    {
        $upperField = Str::upper($field);
        $ucfirstField = Str::ucfirst($field);

        return str_replace(
            [":$field", ":$upperField", ":$ucfirstField"],
            [$value, Str::upper($value), Str::ucfirst($value)],
            $phrase
        );
    }
}
