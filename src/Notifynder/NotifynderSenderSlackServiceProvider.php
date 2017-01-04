<?php

namespace Astrotomic\Notifynder;

use Illuminate\Support\ServiceProvider;
use Astrotomic\Notifynder\Senders\SlackSender;

class NotifynderSenderSlackServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        app('notifynder')->extend('sendSlack', function (array $notifications) {
            return new SlackSender($notifications);
        });
    }
}
