<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../database.php';
include_once __DIR__ . '/../User.php';


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];


$path_parts = explode('/', trim(parse_url($request_uri, PHP_URL_PATH), '/'));
$user_id = null;


foreach ($path_parts as $key => $part) {
    if ($part === 'users' && isset($path_parts[$key + 1]) && is_numeric($path_parts[$key + 1])) {
        $user_id = (int)$path_parts[$key + 1];
        break;
    }
}

function sendResponse($data, $status_code = 200, $message = null) {
    http_response_code($status_code);
    $response = array();

    if ($message) {
        $response['message'] = $message;
    }

    if ($data !== null) {
        $response['data'] = $data;
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

function getJsonInput() {
    $input = file_get_contents('php://input');
    return json_decode($input, true);
}


switch ($method) {
    case 'GET':

        if ($user_id === null) {
            $users = $user->getAll();
            sendResponse($users, 200, "Список пользователей получен успешно");
        } else {

            $user_data = $user->getById($user_id);
            if ($user_data) {
                sendResponse($user_data, 200, "Пользователь найден");
            } else {
                sendResponse(null, 404, "Пользователь не найден");
            }
        }
        break;

    case 'POST':

        $input = getJsonInput();

        if (!isset($input['name']) || empty(trim($input['name']))) {
            sendResponse(null, 400, "Поле 'name' обязательно для заполнения");
        }

        $name = trim($input['name']);
        $created_user = $user->create($name);

        if ($created_user) {
            sendResponse($created_user, 201, "Пользователь создан успешно");
        } else {
            sendResponse(null, 500, "Ошибка при создании пользователя");
        }
        break;

    case 'PUT':

        if ($user_id === null) {
            sendResponse(null, 400, "ID пользователя не указан");
        }

        $input = getJsonInput();

        if (!isset($input['name']) || empty(trim($input['name']))) {
            sendResponse(null, 400, "Поле 'name' обязательно для заполнения");
        }

        $name = trim($input['name']);
        $updated_user = $user->update($user_id, $name);

        if ($updated_user) {
            sendResponse($updated_user, 200, "Данные пользователя обновлены");
        } else {
            sendResponse(null, 404, "Пользователь не найден или ошибка при обновлении");
        }
        break;

    case 'DELETE':

        if ($user_id === null) {
            sendResponse(null, 400, "ID пользователя не указан");
        }


        $existing_user = $user->getById($user_id);
        if (!$existing_user) {
            sendResponse(null, 404, "Пользователь не найден");
        }

        if ($user->delete($user_id)) {
            sendResponse(null, 200, "Пользователь удален успешно");
        } else {
            sendResponse(null, 500, "Ошибка при удалении пользователя");
        }
        break;

    default:
        sendResponse(null, 405, "Метод не поддерживается");
        break;
}

