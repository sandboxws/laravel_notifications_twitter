<?php namespace NotificationChannels\Twitter;

use NotificationChannels\Twitter\Twitter as TwitterClient;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\Exceptions\CouldNotSendNotification;

class TwitterChannel
{
    private $twitter;

    public function __construct(TwitterClient $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Twitter\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var TwitterMessage $message */
        $message = $notification->toTwitter($notifiable);

        if(is_string($message)) {
            $message = TwitterMessage::create($message);
        }

        if ($message->accessTokenNotGiven()) {
            throw CouldNotSendNotification::missingAccessToken();
        }

        if ($message->accessTokenSecretNotGiven()) {
            throw CouldNotSendNotification::missingAccessTokenSecret();
        }

        if ($message->messageNotGiven()) {
            throw CouldNotSendNotification::missingMessage();
        }

        $params = $message->toArray();

        try {
            /** @var \Buzz\Message\Response $response */
            $response = $this->twitter->sendMessage(
                $params['message'],
                $params['accessToken'],
                $params['accessTokenSecret']
            );
        } catch(InvalidResponseException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError();
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNcotCommunicateWithTwitter(
                $exception
            );
        }

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
