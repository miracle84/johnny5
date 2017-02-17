<?php

namespace Johnny5\Services\Validators;

/**
 * Class HttpUrlValidator
 * @package Johnny5\Services\Validators
 */
class HttpUrlValidator implements UrlValidatorInterface
{
    /**
     * @param string $url
     *
     * @return bool
     */
    public function isValid($url)
    {
        $valid = false;

        if (preg_match('/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $url)) {
            $valid = true;
        }

        return $valid;
    }
}
