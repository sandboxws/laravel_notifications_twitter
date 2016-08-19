<?php

namespace NotificationChannels\Twitter\Exceptions;

use Buzz\Message\Response;

class CouldNotSendNotification extends \Exception
{
    /**
     * @param Response $response
     *
     * @return static
     */
    public static function serviceRespondedWithAnError($response = null)
    {
        if ($response) {
            $statusCode = $response->getStatusCode();

            $description = 'no description given';

            if ($reasonPhrase = $response->getReasonPhrase()) {
                $description = $reasonPhrase ?: $description;
            }

            return new static("Twitter responded with an error `{$statusCode} - {$description}`");
        } else {
            return new static("Twitter responded with an error");
        }
    }

    public static function missingConsumerKey()
    {
        return new static(
            'Notification was not sent. Consumer key is missing'
        );
    }

    public static function missingConsumerSecret()
    {
        return new static(
            'Notification was not sent. Consumer secret is missing'
        );
    }

    public static function missingAccessToken()
    {
        return new static(
            'Notification was not sent. Access token is missing'
        );
    }

    public static function missingAccessTokenSecret()
    {
        return new static(
            'Notification was not sent. Access token secret is missing'
        );
    }

    public static function missingMessage()
    {
        return new static(
            'Notification was not sent. Message is missing'
        );
    }

    /**
     * @param \Exception $exception
     *
     * @return static
     */
    public static function couldNotCommunicateWithTwitter($exception)
    {
        return new static(
            "Notification was not sent. Error communicating with Twitter `{$exception->getMessage()}`"
        );
    }
}
