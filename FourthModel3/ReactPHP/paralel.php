<?php

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$client = new React\Http\Browser($loop);

$urls = [
    'https://jsonplaceholder.typicode.com/posts/1',
    'https://jsonplaceholder.typicode.com/posts/2',
    'https://jsonplaceholder.typicode.com/posts/3'
];

$promises = [];
foreach ($urls as $i => $url) {
    $promises[] = $client->get($url)->then(
        function (Psr\Http\Message\ResponseInterface $response) use ($i) {
            echo "Request {$i} completed: " . strlen($response->getBody()) . " bytes\n";
        },
        function (Exception $e) use ($i) {
            echo "Request {$i} failed: " . $e->getMessage() . "\n";
        }
    );
}

echo "All requests are sent in parallel\n";

React\Promise\all($promises)->then(
    function () {
        echo "All requests completed!\n";
    }
);

$loop->run();
