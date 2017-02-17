<?php

namespace Johnny5\Services\Providers;

/**
 * Interface UrlProviderInterface
 * @package Johnny5\Services\Providers
 */
interface UrlProviderInterface
{
    /**
     * @param string $resourceName
     */
    public function init($resourceName);
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return bool
     */
    public function isEnd();
}
