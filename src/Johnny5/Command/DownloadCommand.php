<?php

namespace Johnny5\Command;

use Johnny5\Kernel\Command\AbstractCommand;
use Johnny5\Kernel\ServiceContainer;
use Johnny5\Kernel\Model\ConsoleOption;
use Johnny5\Model\UrlProcessing;
use Johnny5\Services\BotService;
use Johnny5\Services\ConsoleViewService;
use Johnny5\Services\DownloadService;

/**
 * Class DownloadCommand
 * @package Johnny5\Command
 */
class DownloadCommand extends AbstractCommand
{
    public function config()
    {
        $this
            ->setName('download')
            ->setDescription('Downloads images from the download queue to local temporary folder.')
            ->addOption('limit', ConsoleOption::OPTIONAL, 'Get only this amount of urls from queue')
            ->addOption('force', ConsoleOption::BLANK, 'Rewrite file, if exists');
    }

    public function execute()
    {
        /** @var BotService $botService */
        $botService = ServiceContainer::getInstance()->get('service.bot');

        $limit = (int)$this->getOptionValue('limit');
        $rewrite = $this->hasOptionValue('force');

        /** @var DownloadService $downloadService */
        $downloadService = ServiceContainer::getInstance()->get('service.download');

        /** @var UrlProcessing[] $urlProcessingList */
        $urlProcessingList = $botService->download($downloadService, $rewrite, $limit);

        /** @var ConsoleViewService $consoleViewService */
        $consoleViewService = ServiceContainer::getInstance()->get('service.console_view');

        $consoleViewService->showUrlProcessingReport($urlProcessingList);
    }
}
