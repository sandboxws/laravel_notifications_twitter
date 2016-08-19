<?php

namespace NotificationChannels\Twitter;

class TwitterMessage
{
    /** @var string message */
    private $message;

    /** @var string access token */
    private $accessToken;

    /** @var string access token secret */
    private $accessTokenSecret;

    /** @var array $params */
    private $params;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public static function create($message = '')
    {
        return new static($message);
    }

    /**
     * @param string $message
     */
    public function status($message)
    {
        $this->params['message'] = $message;

        return $this;
    }

    /**
     * User access token
     * @param $accessToken
     *
     * @return $this
     */
    public function accessToken($accessToken)
    {
        $this->params['accessToken'] = $accessToken;

        return $this;
    }

    /**
     * User access token secret
     * @param $accessTokenSecret
     *
     * @return $this
     */
    public function accessTokenSecret($accessTokenSecret)
    {
        $this->params['accessTokenSecret'] = $accessTokenSecret;

        return $this;
    }

    /**
     * Determines if the status/message is not given.
     *
     * @return bool
     */
    public function messageNotGiven()
    {
        return !isset($this->message);
    }

    /**
     * Determines if the access token is not given.
     *
     * @return bool
     */
    public function accessTokenNotGiven()
    {
        return !isset($this->accessToken);
    }

    /**
     * Determines if the access token secret is not given.
     *
     * @return bool
     */
    public function accessTokenSecretNotGiven()
    {
        return !isset($this->accessTokenSecret);
    }

    /**
     * Returns params payload
     *
     * @return array
     */
    public function toArray()
    {
        return $this->params;
    }
}
