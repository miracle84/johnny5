<?php

namespace Johnny5\Kernel\Model;

/**
 * Class ConsoleArgument
 * @package Johnny5\Kernel\Model
 */
class ConsoleArgument
{
    const REQUIRED = 1;
    const OPTIONAL = 2;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var string */
    protected $mode;

    /**
     * ConsoleArgument constructor.
     * @param string $name
     * @param string $mode
     * @param string $description
     */
    public function __construct($name, $mode, $description = '')
    {
        $this->name = $name;
        $this->mode = $mode;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }
}
