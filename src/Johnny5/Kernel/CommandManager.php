<?php

namespace Johnny5\Kernel;

use Exception;
use Johnny5\Kernel\Command\AbstractCommand;
use Johnny5\Kernel\Model\ConsoleArgument;
use Johnny5\Kernel\Model\ConsoleOption;

/**
 * Class CommandManager
 * @package Johnny5\Kernel
 */
class CommandManager
{
    /** @var array */
    protected $consoleArgDataList;

    /** @var AbstractCommand */
    protected $command;

    /**
     * CommandManager constructor.
     * @param array $consoleArgDataList
     */
    public function __construct(array $consoleArgDataList = [])
    {
        $this->consoleArgDataList = $consoleArgDataList;
        $this->initConsoleCommand($consoleArgDataList);
        $this->parseConsoleData($consoleArgDataList);
    }

    /**
     * @param $consoleArgDataList
     * @throws Exception
     */
    protected function initConsoleCommand($consoleArgDataList)
    {
        if (empty($consoleArgDataList[1])) {
            throw new Exception('Command name is empty');
        }

        /** @var AbstractCommand[] $commandList */
        $commandList = ServiceContainer::getInstance()->getListByTag('command');

        if (!$commandList) {
            throw new Exception('Empty command list');
        }

        $commandName = $consoleArgDataList[1];

        $command = array_filter($commandList, function ($commandInfo) use ($commandName) {
            /** @var AbstractCommand $commandInfo */
            return ($commandInfo->getName() === $commandName);
        });

        if (!$command) {
            throw new Exception('Command ' . $commandName . ' not found');
        }

        if (count($command) > 1) {
            throw new Exception('Found more than one command with name ' . $commandName);
        }

        $this->command = current($command);
    }

    /**
     * @param array $consoleArgDataList
     * @throws Exception
     */
    protected function parseConsoleData(array $consoleArgDataList = [])
    {
        /** remove script name */
        unset($consoleArgDataList[0]);
        /** remove command name */
        unset($consoleArgDataList[1]);

        if (!$this->command instanceof AbstractCommand) {
            throw new Exception('Command must be instance of AbstractCommand');
        }

        if ($this->command->getOptionList()) {

            $optionValueList = [];

            foreach ($this->command->getOptionList() as $option) {
                $ind = array_search('-' . $option->getName(), $consoleArgDataList);
                if (false === $ind) {
                    if (ConsoleOption::REQUIRED === $option->getMode()) {
                        throw new Exception('Required option ' . $option->getName() . 'does not exists');
                    }
                    continue;
                }

                unset($consoleArgDataList[$ind]);
                $optionValue = null;

                $ind++;
                /** use array_key_exists(instead isset) because we should remove value although it may be null */
                if (ConsoleOption::BLANK !== $option->getMode() && array_key_exists($ind, $consoleArgDataList)) {
                    $optionValue = $consoleArgDataList[$ind];
                    unset($consoleArgDataList[$ind]);
                }

                if (!$optionValue && ConsoleOption::REQUIRED === $option->getMode()) {
                    throw new Exception('Required option ' . $option->getName() . ' is empty');
                }

                $optionValueList[$option->getName()] = $optionValue;
            }

            $this->command->setOptionValueList($optionValueList);
        }

        if ($this->command->getArgumentList()) {

            $argumentValueList = [];
            reset($consoleArgDataList);

            foreach ($this->command->getArgumentList() as $argument) {
                $argumentName = $argument->getName();
                $argumentValue = current($consoleArgDataList);
                if (false === $argumentValue) {
                    if (ConsoleArgument::REQUIRED === $argument->getMode()) {
                        throw new Exception('Required argument ' . $argument->getName() . ' does not exists');
                    }
                    continue;
                }
                next($consoleArgDataList);
                $argumentValueList[$argumentName] = $argumentValue;
            }

            $this->command->setArgumentValueList($argumentValueList);
        }
    }

    public function execute()
    {
        $this->command->execute();
    }
}
