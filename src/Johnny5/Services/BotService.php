<?php

namespace Johnny5\Services;

use Johnny5\Model\UrlProcessing;
use Johnny5\Services\Providers\UrlProviderInterface;
use Johnny5\Services\Validators\UrlValidatorInterface;

/**
 * Class BotService
 * @package Johnny5\Services
 */
class BotService
{
    const QUEUE_DOWNLOAD = 'download';
    const QUEUE_DONE = 'done';
    const QUEUE_FAILED = 'failed';

    /** @var QueueInterface */
    protected $queueService;

    /** @var UrlValidatorInterface */
    protected $urlValidator;

    public function __construct(QueueInterface $queueService, UrlValidatorInterface $urlValidator)
    {
        $this->queueService = $queueService;
        $this->urlValidator = $urlValidator;
    }

    /**
     * @param UrlProviderInterface $urlProvider
     * @return UrlProcessing[]
     */
    public function scheduler(UrlProviderInterface $urlProvider)
    {
        $urlProcessingList = [];

        while (false === $urlProvider->isEnd()) {

            $url = $urlProvider->getUrl();
            $urlProcessing = new UrlProcessing();
            $urlProcessing->setUrl($url);

            if (true === $this->urlValidator->isValid($url)) {
                $this->queueService->publish(self::QUEUE_DOWNLOAD, $url);
                $urlProcessing->setStatus(UrlProcessing::STATUS_SUCCESS);
            } else {
                $urlProcessing->setStatus(UrlProcessing::STATUS_FAIL);
                $urlProcessing->setMessage('Url is not valid');
            }

            $urlProcessingList[] = $urlProcessing;
        }

        return $urlProcessingList;
    }

    /**
     * @param DownloadService $downloadService
     * @param bool $rewrite
     * @param int $limit
     *
     * @return UrlProcessing[]
     */
    public function download(DownloadService $downloadService, $rewrite = false, $limit = 0)
    {
        $urlProcessingList = [];
        $count = 0;

        while (!$limit || $count < $limit) {

            $url = $this->queueService->consume(self::QUEUE_DOWNLOAD);
            if (false === $url) {
                break;
            }

            $isValid = $this->urlValidator->isValid($url);
            $urlProcessing = new UrlProcessing();
            $urlProcessing->setUrl($url);

            if ($isValid) {
                $isDownload = $downloadService->imageDownload($url, $rewrite);
                if ($isDownload) {
                    $urlProcessing->setStatus(UrlProcessing::STATUS_SUCCESS);
                    $this->queueService->publish(self::QUEUE_DONE, $url);
                } else {
                    $urlProcessing->setStatus(UrlProcessing::STATUS_FAIL);
                    $this->queueService->publish(self::QUEUE_FAILED, $url);
                }
            } else {
                $urlProcessing->setStatus(UrlProcessing::STATUS_FAIL);
                $this->queueService->publish(self::QUEUE_FAILED, $url);
            }

            $urlProcessingList[] = $urlProcessing;
            $count++;
        }

        return $urlProcessingList;
    }
}
