# Notifynder 4 Slack Sender - Laravel 5

[![GitHub release](https://img.shields.io/github/release/astrotomic/notifynder-sender-slack.svg?style=flat-square)](https://github.com/astrotomic/notifynder-sender-slack/releases)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://raw.githubusercontent.com/astrotomic/notifynder-sender-slack/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/astrotomic/notifynder-sender-slack.svg?style=flat-square)](https://github.com/astrotomic/notifynder-sender-slack/issues)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/notifynder-sender-slack.svg?style=flat-square)](https://packagist.org/packages/astrotomic/notifynder-sender-slack)

[![StyleCI](https://styleci.io/repos/78016547/shield)](https://styleci.io/repos/78016547)

[![Code Climate](https://img.shields.io/codeclimate/github/Astrotomic/notifynder-sender-slack.svg?style=flat-square)](https://codeclimate.com/github/Astrotomic/notifynder-sender-slack)

[![Slack Team](https://img.shields.io/badge/slack-astrotomic-orange.svg?style=flat-square)](https://astrotomic.slack.com)
[![Slack join](https://img.shields.io/badge/slack-join-green.svg?style=social)](https://notifynder.signup.team)


Documentation: **[Notifynder Docu](http://notifynder.info)**

-----

## Installation

### Step 1

```
composer require astrotomic/notifynder-sender-slack
```

### Step 2

Add the following string to `config/app.php`

**Providers array:**

```
Astrotomic\Notifynder\NotifynderSenderSlackServiceProvider::class,
```

### Step 3

Add the following array to `config/notifynder.php`

```php
'senders' => [
    'slack' => [
        'webhook' => 'https://hooks.slack.com/...',
        'store' => false, // wether you want to also store the notifications in database
    ],
],
```

Register the sender callback in your `app/Providers/AppServiceProvider.php`

```php
<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Astrotomic\Notifynder\Senders\SlackSender;
use Maknz\Slack\Message as SlackMessage;
use Fenos\Notifynder\Builder\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('notifynder.sender')->setCallback(SlackSender::class, function (SlackMessage $message, Notification $notification) {
            // handle the message and append the from, to, icon and so on
            // https://github.com/maknz/slack#explicit-message-creation
            // you don't have to set the message text, by default (if empty) it is set in the sender itself
            // just return the message, don't send it - otherwise you will get the message two times
            return $message;
        });
    }
}
```