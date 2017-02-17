<?php

namespace Johnny5\Services\Validators;

/**
 * Interface UrlValidatorInterface
 * @package Johnny5\Services\Validators
 */
interface UrlValidatorInterface
{
    /** @var $url string */
    public function isValid($url);
}
