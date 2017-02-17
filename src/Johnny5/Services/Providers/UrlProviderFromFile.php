<?php

namespace Johnny5\Services\Providers;

use Exception;

/**
 * Class UrlProviderFromFile
 * @package Johnny5\Services\Providers
 */
class UrlProviderFromFile implements UrlProviderInterface
{
    const MAX_LENGTH = 2000;

    /** @var resource */
    protected $fileResource = null;

    /**
     * @param string $fileName
     * @throws Exception
     */
    public function init($fileName)
    {
        set_error_handler(function () {

        });// don't want to get warnings, for current task enough check return value
        $this->fileResource = fopen($fileName, 'r');
        restore_error_handler();

        if (!$this->fileResource) {
            throw new Exception('Can\' open resource ' . $fileName);
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $url = trim(fgets($this->fileResource, self::MAX_LENGTH));

        return $url;
    }

    /**
     * @return bool
     */
    public function isEnd()
    {
        return feof($this->fileResource);
    }

    public function __destruct()
    {
        if ($this->fileResource) {
            fclose($this->fileResource);
        }
    }
}
