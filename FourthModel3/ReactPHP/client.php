<?php

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$client = new React\Http\Browser($loop);

$client->get('https://jsonplaceholder.typicode.com/posts/1')->then(
    function (Psr\Http\Message\ResponseInterface $response) {
        echo 'Response received: ' . $response->getBody() . PHP_EOL;
    },
    function (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    }
);

echo "This message appears immediately, before the response is received\n";

$loop->run();

