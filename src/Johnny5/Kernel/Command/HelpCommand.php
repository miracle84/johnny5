<?php

namespace Johnny5\Kernel\Command;

use Johnny5\Kernel\Model\ConsoleOption;
use Johnny5\Kernel\ServiceContainer;

/**
 * Class HelpCommand
 * @package Johnny5\Command
 */
class HelpCommand extends AbstractCommand
{
    public function config()
    {
        $this
            ->setName('help')
            ->setDescription('Show help information.');
    }

    public function execute()
    {
        /** @var AbstractCommand[] $commandList */
        $commandList = ServiceContainer::getInstance()->getListByTag('command');

        echo 'Command list: ' . PHP_EOL;
        echo '====================' . PHP_EOL;
        foreach ($commandList as $command) {
            echo PHP_EOL . ' ' . $command->getName() . ' - ' . $command->getDescription() . PHP_EOL;

            $optionList = $command->getOptionList();
            if ($optionList) {
                echo '  ' . 'Options list: ' . PHP_EOL;
                foreach ($optionList as $option) {
                    $req = (ConsoleOption::REQUIRED === $option->getMode() ? ' (req) ' : '');
                    echo '    ' . '-' . $option->getName() . $req . ' --- ' . $option->getDescription() . PHP_EOL;
                }
            }

            $argumentList = $command->getArgumentList();
            if ($argumentList) {
                echo '  ' . 'Arguments list: ' . PHP_EOL;
                foreach ($argumentList as $argument) {
                    $req = (ConsoleOption::REQUIRED === $argument->getMode() ? ' (req) ' : '');
                    echo '    ' . '-' . $argument->getName() . $req . ' --- ' . $argument->getDescription() . PHP_EOL;
                }
            }
        }
    }
}
