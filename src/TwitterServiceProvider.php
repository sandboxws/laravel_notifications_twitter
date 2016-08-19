<?php

namespace NotificationChannels\Twitter;

use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(TwitterChannel::class)
            ->needs(Twitter::class)
            ->give(function () {
                return new Twitter(
                    //'3lOQywUf5h3eHpJJCLTTuP79Y',
                    config('services.twitter.consumer_key'),
                    //'nPSGBJ8XbwEeIdmEHKJw97aIjZHtomWfTjYj5dYx1DmTkZM6ks',
                    config('services.twitter.consumer_secret')
                );
            });
    }
}
