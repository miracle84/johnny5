<?php

namespace Johnny5\Model;

/**
 * Class UrlProcessing
 * @package Johnny5\Model
 */
class UrlProcessing
{
    const STATUS_SUCCESS = true;
    const STATUS_FAIL = false;

    /** @var string */
    protected $url;

    /** @var string */
    protected $status;

    /** @var string */
    protected $message = '';

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return UrlProcessing
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return UrlProcessing
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return UrlProcessing
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
