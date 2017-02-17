<?php

namespace Johnny5\Services;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class RabbitMQService
 * @package Johnny5\Services
 */
class RabbitMQService implements QueueInterface
{
    /** @var string */
    protected $exchange;

    /** @var AMQPChannel */
    protected $ch;

    /** @var AMQPStreamConnection */
    protected $conn;

    /** @var array */
    protected $exchangeList = [];

    /**
     * RabbitMQService constructor.
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     */
    public function __construct($host, $port, $user, $password, $vhost)
    {
        $this->conn = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $this->ch = $this->conn->channel();
    }

    public function __destruct()
    {
        $this->ch->close();
        $this->conn->close();
    }

    /**
     * @param $queue
     *
     * @return string
     */
    protected function getExchange($queue)
    {
        if (!array_key_exists($queue, $this->exchangeList)) {
            /**
             * queue and exchange the same
             */
            $exchange = $queue;
            $this->ch->queue_declare($queue, false, true, false, false);
            $this->ch->exchange_declare($exchange, 'direct', false, true, false);
            $this->ch->queue_bind($queue, $exchange);

            $this->exchangeList[$exchange] = $exchange;
        }

        return $queue;
    }

    /**
     * @param $queue
     * @param $message
     *
     * @return bool
     */
    public function publish($queue, $message)
    {
        $exchange = $this->getExchange($queue);
        $msg = new AMQPMessage($message, array('content_type' => 'text/plain', 'delivery_mode' => 2));
        $this->ch->basic_publish($msg, $exchange);

        return true;
    }

    /**
     * @param $queue
     *
     * @return mixed
     */
    public function consume($queue)
    {
        $messageBody = false;

        $message = $this->ch->basic_get($queue);
        if ($message) {
            $this->ch->basic_ack($message->delivery_info['delivery_tag']);
            $messageBody = $message->body;
        }

        return $messageBody;
    }
}
