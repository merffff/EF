<?php


$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];


$path = parse_url($request_uri, PHP_URL_PATH);


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($request_method === 'OPTIONS') {
    http_response_code(200);
    exit;
}


switch (true) {

    case preg_match('#^/graphql/?.*#', $path):
        include_once __DIR__ . '/graphql/index.php';
        break;


    case preg_match('#^/api/users/?.*#', $path):
        include_once __DIR__ . '/api/users.php';
        break;


    default:

        $file_path = __DIR__ . $path;

        if (is_file($file_path)) {

            return false;
        } else {

            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Маршрут не найден',
                'path' => $path,
                'available_endpoints' => [
                    'REST API' => '/api/users',
                    'GraphQL' => '/graphql'
                ]
            ], JSON_UNESCAPED_UNICODE);
        }
        break;
}

