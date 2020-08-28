<?php

namespace App\Log;

use Gelf\Publisher;
use Gelf\Transport\HttpTransport;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;

class GraylogLoggerFactory
{

    public function __invoke(array $config)
    {
        $logger = new Logger($config['name']);

        $transport = new HttpTransport($config['host'], $config['port'], $config['path']);
        $publisher = new Publisher($transport);
        $graylogHandler = new GelfHandler($publisher);

        $logger->pushHandler($graylogHandler);

        return $logger;

    }

}
