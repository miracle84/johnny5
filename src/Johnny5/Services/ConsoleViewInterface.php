<?php

namespace Johnny5\Services;

use Johnny5\Model\UrlProcessing;

/**
 * Interface ConsoleViewInterface
 * @package Johnny5\Services
 */
interface ConsoleViewInterface
{
    /**
     * @param UrlProcessing[] $urlProcessingList
     */
    public function showUrlProcessingReport(array $urlProcessingList = null);
}
