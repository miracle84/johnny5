<?php

namespace Johnny5\Services;

use Johnny5\Model\UrlProcessing;

/**
 * Class ConsoleViewService
 * @package Johnny5\Services
 */
class ConsoleViewService implements ConsoleViewInterface
{
    /**
     * @param UrlProcessing[] $urlProcessingList
     */
    public function showUrlProcessingReport(array $urlProcessingList = null)
    {
        if ($urlProcessingList) {
            echo '-----------------'.PHP_EOL;
            echo '| Reporting...'.PHP_EOL;
            echo '-----------------'.PHP_EOL;
            foreach ($urlProcessingList as $urlProcessing) {
                $status = (UrlProcessing::STATUS_SUCCESS === $urlProcessing->getStatus()) ? 'Successful' : 'Fail';
                echo $status . ' : ' . substr($urlProcessing->getUrl(), 0, 20) . '...' . PHP_EOL;
            }
        } else {
            echo 'Report is empty' . PHP_EOL;
        }
    }

    public function showLine($text)
    {

    }
}
