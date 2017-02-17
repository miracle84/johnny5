<?php

namespace Johnny5\Kernel\Command;

use Johnny5\Kernel\Model\ConsoleArgument;
use Johnny5\Kernel\Model\ConsoleOption;

/**
 * Class AbstractCommand
 * @package Johnny5\Kernel\Command
 */
abstract class AbstractCommand implements CommandInterface
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var ConsoleArgument[] */
    protected $argumentList = [];

    /** @var ConsoleOption[] */
    protected $optionList = [];

    /** @var array */
    protected $argumentValueList = [];

    /** @var array */
    protected $optionValueList = [];

    public function __construct()
    {
        $this->config();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    protected function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    protected function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $name
     * @param string $mode
     * @param string $description
     *
     * @return $this
     */
    protected function addArgument($name, $mode, $description = '')
    {
        $argument = new ConsoleArgument($name, $mode, $description);
        $this->argumentList[$name] = $argument;

        return $this;
    }

    /**
     * @param string $name
     * @param string $mode
     * @param string $description
     *
     * @return $this
     */
    protected function addOption($name, $mode, $description = '')
    {
        $option = new ConsoleOption($name, $mode, $description);
        $this->optionList[$name] = $option;

        return $this;
    }

    /**
     * @return ConsoleArgument[]
     */
    public function getArgumentList()
    {
        return $this->argumentList;
    }

    /**
     * @return ConsoleOption[]
     */
    public function getOptionList()
    {
        return $this->optionList;
    }

    /**
     * @return array
     */
    public function getArgumentValueList()
    {
        return $this->argumentValueList;
    }

    /**
     * @return array
     */
    public function getOptionValueList()
    {
        return $this->optionValueList;
    }

    /**
     * @param ConsoleOption[] $optionList
     *
     * @return AbstractCommand
     */
    public function setOptionList($optionList)
    {
        $this->optionList = $optionList;

        return $this;
    }

    /**
     * @param array $optionValueList
     *
     * @return AbstractCommand
     */
    public function setOptionValueList($optionValueList)
    {
        $this->optionValueList = $optionValueList;

        return $this;
    }

    /**
     * @param array $argumentValueList
     *
     * @return AbstractCommand
     */
    public function setArgumentValueList($argumentValueList)
    {

        $this->argumentValueList = $argumentValueList;

        return $this;
    }

    /**
     * @param ConsoleArgument[] $argumentList
     *
     * @return AbstractCommand
     */
    public function setArgumentList($argumentList)
    {
        $this->argumentList = $argumentList;

        return $this;
    }

    /**
     * @param $argumentName
     *
     * @return string|null
     */
    public function getArgumentValue($argumentName)
    {
        return (isset($this->argumentValueList[$argumentName])) ? $this->argumentValueList[$argumentName] : null;
    }

    /**
     * @param $optionName
     *
     * @return string|null
     */
    public function getOptionValue($optionName)
    {
        return (isset($this->optionValueList[$optionName])) ? $this->optionValueList[$optionName] : null;
    }

    /**
     * @param $optionName
     *
     * @return bool
     */
    public function hasOptionValue($optionName)
    {
        return array_key_exists($optionName, $this->optionValueList);
    }
}
