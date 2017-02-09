<?php

namespace Astrotomic\Notifynder\Senders;

use Fenos\Notifynder\Traits\SenderCallback;
use Maknz\Slack\Client;
use Fenos\Notifynder\Contracts\SenderContract;
use Fenos\Notifynder\Contracts\SenderManagerContract;

class SlackSender implements SenderContract
{
    use SenderCallback;
    
    /**
     * @var array
     */
    protected $notifications;

    /**
     * @var array
     */
    protected $config;

    /**
     * SlackSender constructor.
     *
     * @param array $notifications
     */
    public function __construct(array $notifications)
    {
        $this->notifications = $notifications;
        $this->config = notifynder_config('senders.slack');
    }

    /**
     * Send all notifications.
     *
     * @param SenderManagerContract $sender
     * @return bool
     */
    public function send(SenderManagerContract $sender)
    {
        $webhook = $this->config['webhook'];
        $store = $this->config['store'];
        $callback = $this->getCallback();
        $client = new Client($webhook);
        foreach ($this->notifications as $notification) {
            $message = call_user_func($callback, $client->createMessage(), $notification);
            if (empty($message->getText())) {
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
