<?php

namespace Astrotomic\Notifynder\Senders;

use Fenos\Notifynder\Contracts\SenderContract;
use Fenos\Notifynder\Contracts\SenderManagerContract;
use Maknz\Slack\Client;

class SlackSender implements SenderContract
{
    /**
     * @var array
     */
    protected $notifications;

    /**
     * SlackSender constructor.
     *
     * @param array $notifications
     */
    public function __construct(array $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Send all notifications.
     *
     * @param SenderManagerContract $sender
     * @return bool
     */
    public function send(SenderManagerContract $sender)
    {
        $webhook = config('notifynder.senders.slack.webhook');
        $callback = config('notifynder.senders.slack.callback');
        $store = config('notifynder.senders.slack.store', false);
        $client = new Client($webhook);
        foreach ($this->notifications as $notification) {
            $message = call_user_func($callback, $client->createMessage(), $notification);
            if(empty($message->getText())) {
                $message->setText($notification->getText());
            }
            $message->send();
        }

        if ($store) {
            return $sender->send($this->notifications);
        }

        return true;
    }
}
