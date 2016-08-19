<?php namespace NotificationChannels\Twitter;

use Endroid\Twitter\Twitter as TwitterClient;
use NotificationChannels\Twitter\Exceptions\CouldNotSendNotification;

class Twitter
{
    /** @var TwitterClient */
    protected $twitter;

    public function __construct($consumerKey, $consumerSecret)
    {
        $this->consumerKey = $consumerKey;

        $this->consumerSecret = $consumerSecret;
    }

    private function validateConsumer()
    {
        if (empty($this->consumerKey)) {
            throw CouldNotSendNotification::missingConsumerKey();
        }

        if (empty($this->consumerSecret)) {
            throw CouldNotSendNotification::missingConsumerSecret();
        }
    }

    public function sendMessage($status, $accessToken, $accessTokenSecret)
    {
        $this->validateConsumer();

        return $this->sendRequest($status, $accessToken, $accessTokenSecret);
    }

    /**
     * Sends a Twitter API status update and return response.
     *
     * @param $status
     *
     * @throws CouldNotSendNotification
     *
     * @return array
     */
    protected function sendRequest($status, $accessToken, $accessTokenSecret)
    {
        $twitter = new TwitterClient(
            $this->consumerKey, $this->consumerSecret,
            $accessToken, $accessTokenSecret
        );

        $parameters = [
            'status' => $status,
        ];

        $response = $twitter->query(
            'statuses/update', 'POST', 'json', $parameters
        );

        return json_decode($response->getContent(), true);
    }
}
