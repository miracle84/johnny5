<?php

namespace Johnny5\Services;

use Exception;

/**
 * Class DownloadService
 * @package Johnny5\Services
 */
class DownloadService
{

    /** @var string */
    protected $downloadFolder;

    /**
     * DownloadService constructor.
     * @param string $downloadFolder
     */
    public function __construct($downloadFolder = '')
    {
        $this->downloadFolder = $downloadFolder;
    }

    /**
     * @param $url
     * @param bool $rewrite
     * @param string $file
     *
     * @return bool
     */
    public function imageDownload($url, $rewrite = false, $file = '')
    {
        $result = true;
        if (!$file) {
            $file = md5($url);
        }
        $fileFullPath = $this->downloadFolder . '/' . $file;

        if ($rewrite || !file_exists($fileFullPath)) {
            try {
                $img = file_get_contents($url);
                if ($img) {
                    file_put_contents($fileFullPath, $img);
                } else {
                    $result = false;
                }
            } catch (Exception $e) {
                $result = false;
            }
        } else {
            $result = false;
        }

        return $result;
    }
}
