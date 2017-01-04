<?php

namespace Astrotomic\Notifynder;

use Astrotomic\Notifynder\Senders\EmailSender;
use Astrotomic\Notifynder\Senders\SlackSender;
use Illuminate\Support\ServiceProvider;

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
