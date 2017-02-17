<?php

namespace Johnny5\Command;

use Johnny5\Kernel\Command\AbstractCommand;
use Johnny5\Kernel\ServiceContainer;
use Johnny5\Kernel\Model\ConsoleArgument;
use Johnny5\Model\UrlProcessing;
use Johnny5\Services\BotService;
use Johnny5\Services\ConsoleViewService;
use Johnny5\Services\Providers\UrlProviderInterface;

/**
 * Class ScheduleCommand
 * @package Johnny5\Command
 */
class ScheduleCommand extends AbstractCommand
{
    public function config()
    {
        $this
            ->setName('schedule')
            ->setDescription('Accepts a file with list of URLs to download and schedule them for download.')
            ->addArgument('fileName', ConsoleArgument::REQUIRED, 'Name of the file with URLs');
    }

    public function execute()
    {
        /** @var $urlProvider UrlProviderInterface */
        $urlProvider = ServiceContainer::getInstance()->get('provider.url_from_file');
        $urlProvider->init($this->getArgumentValue('fileName'));

        /** @var $botService BotService */
        $botService = ServiceContainer::getInstance()->get('service.bot');
        /** @var UrlProcessing[] $urlProcessingList */
        $urlProcessingList = $botService->scheduler($urlProvider);

        /** @var ConsoleViewService $consoleViewService */
        $consoleViewService = ServiceContainer::getInstance()->get('service.console_view');

        $consoleViewService->showUrlProcessingReport($urlProcessingList);
    }
}
