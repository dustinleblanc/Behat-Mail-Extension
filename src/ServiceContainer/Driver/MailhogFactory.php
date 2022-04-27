<?php

namespace tPayne\BehatMailExtension\ServiceContainer\Driver;

use GuzzleHttp\Client;
use tPayne\BehatMailExtension\Driver\Mailhog;

class MailhogFactory implements MailFactory
{

  /**
   * @param array $config
   *
   * @return \tPayne\BehatMailExtension\Driver\Mailhog
   */
    public function buildDriver(array $config): Mailhog
    {
        $client = new Client(['base_uri' => $this->buildURL($config)]);
        return new Mailhog($client);
    }

  /**
   * @param array $config
   *
   * @return string
   */
    private function buildURL(array $config): string
    {
        return "http://{$config['base_uri']}:{$config['http_port']}";
    }
}
