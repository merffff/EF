<?php


use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;


$server = new Server("0.0.0.0", 9501);


$server->set([
    'worker_num' => 4,
    'daemonize' => false,
    'log_file' => '/tmp/swoole.log',
    'log_level' => SWOOLE_LOG_INFO,
]);


$server->on("request", function (Request $request, Response $response) {

    $response->header("Content-Type", "application/json");
    $response->header("Access-Control-Allow-Origin", "*");
    $response->header("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
    $response->header("Access-Control-Allow-Headers", "Content-Type");


    $method = $request->server['request_method'];
    $uri = $request->server['request_uri'];
    $timestamp = date('Y-m-d H:i:s');

    $responseData = [
        'status' => 'success',
        'message' => 'Swoole HTTP Server работает асинхронно!',
        'timestamp' => $timestamp,
        'method' => $method,
        'uri' => $uri,
        'server_info' => [
            'swoole_version' => SWOOLE_VERSION,
            'php_version' => PHP_VERSION,
            'worker_pid' => getmypid()
        ]
    ];


    echo "[{$timestamp}] {$method} {$uri} - Worker PID: " . getmypid() . "\n";


    $response->end(json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
});


$server->on("start", function (Server $server) {
    echo "🚀 Swoole HTTP Server запущен на http://0.0.0.0:9501\n";
    echo "📝 Версия Swoole: " . SWOOLE_VERSION . "\n";
    echo "🐘 Версия PHP: " . PHP_VERSION . "\n";
    echo "⚡ Асинхронный режим активен!\n";
    echo "\n--- Для проверки выполните: curl http://localhost:9501 ---\n\n";
});


$server->on("workerStart", function (Server $server, int $workerId) {
    echo "Worker #{$workerId} запущен (PID: " . getmypid() . ")\n";
});


$server->on("shutdown", function () {
    echo "🛑 Swoole HTTP Server остановлен\n";
});


$server->start();
