<?php

namespace Johnny5\Kernel\Command;

/**
 * Interface CommandInterface
 * @package Johnny5\Kernel\Command
 */
interface CommandInterface
{
    public function config();
    public function execute();
}
