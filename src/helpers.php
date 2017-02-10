<?php

if (! function_exists('camel_case_to_underscore')) {

    /**
     * @param string $input
     * @return string
     */
    function camel_case_to_underscore(string $input): string
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $input)), '_');
    }
}
if (! function_exists('remove_phrase_in_the_end')) {

    /**
     * @param string $input
     * @param string $phrase
     * @return string
     */
    function remove_phrase_in_the_end(string $input, string $phrase): string
    {
        return preg_replace("/{$phrase}$/", '', $input);
    }
}
