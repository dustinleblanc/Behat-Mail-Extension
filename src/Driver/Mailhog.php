<?php

namespace tPayne\BehatMailExtension\Driver;

use GuzzleHttp\Client;
use tPayne\BehatMailExtension\MessageFactory;

class Mailhog implements Mail
{

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function getLatestMessage()
    {
        return $this->getMessages()[0];
    }

    /**
     * @inheritDoc
     */
    public function getMessages()
    {
        $body = $this->client->get('/api/v1/messages')->getBody()->getContents();
        $messageData = json_decode($body, true);
        return array_map(function ($message) {
            return $this->mapToMessage($message);
        }, $messageData);
    }

    /**
     * @inheritDoc
     */
    public function deleteMessages()
    {
        $this->client->delete('/api/v1/messages');
    }

    /**
     * @param $message
     *
     * @return \tPayne\BehatMailExtension\Message
     */
    private function mapToMessage($message)
    {
        return MessageFactory::fromMailHog($message);
    }
}
