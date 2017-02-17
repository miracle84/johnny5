<?php

namespace Johnny5\Services;

/**
 * Interface QueueInterface
 * @package Johnny5\Services
 */
interface QueueInterface
{
    /**
     * @param $queue
     * @param $message
     *
     * @return mixed
     */
    public function publish($queue, $message);

    /**
     * @param $queue
     *
     * @return mixed
     */
    public function consume($queue);
}
