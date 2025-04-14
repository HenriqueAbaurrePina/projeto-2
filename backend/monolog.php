<?php
require 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Formatter\ElasticsearchFormatter;
use Elasticsearch\ClientBuilder;

function getLogger(): Logger {
    $client = ClientBuilder::create()
        ->setHosts(['elasticsearch:9200'])
        ->build();

    $logger = new Logger('app');

    $options = [
        'index' => 'php-logs',
        'type' => '_doc'
    ];

    $handler = new ElasticsearchHandler($client, $options);
    $handler->setFormatter(new ElasticsearchFormatter('php-logs', '_doc'));

    $logger->pushHandler($handler);

    return $logger;
}
