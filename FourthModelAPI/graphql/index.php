<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Обработка OPTIONS-запроса для CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

include_once __DIR__ . '/../database.php';
include_once __DIR__ . '/../User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);


class SimpleGraphQLParser {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function execute($query, $variables = null) {
        $query = trim($query);


        if (strpos($query, 'mutation') === 0) {
            return $this->handleMutation($query, $variables);
        } else {
            return $this->handleQuery($query, $variables);
        }
    }

    private function handleQuery($query, $variables) {

        if (preg_match('/users\s*\{([^}]+)\}/', $query, $matches)) {
            $fields = $this->parseFields($matches[1]);
            $users = $this->user->getAll();

            $result = array();
            foreach ($users as $user) {
                $userResult = array();
                foreach ($fields as $field) {
                    if (isset($user[$field])) {
                        $userResult[$field] = $user[$field];
                    }
                }
                $result[] = $userResult;
            }

            return array('data' => array('users' => $result));
        }


        if (preg_match('/getUser\s*\(\s*id\s*:\s*(\d+)\s*\)\s*\{([^}]+)\}/', $query, $matches)) {
            $userId = (int)$matches[1];
            $fields = $this->parseFields($matches[2]);
            $userData = $this->user->getById($userId);

            if ($userData) {
                $result = array();
                foreach ($fields as $field) {
                    if (isset($userData[$field])) {
                        $result[$field] = $userData[$field];
                    }
                }
                return array('data' => array('getUser' => $result));
            } else {
                return array(
                    'data' => array('getUser' => null),
                    'errors' => array(array('message' => 'Пользователь не найден'))
                );
            }
        }

        return array('errors' => array(array('message' => 'Неизвестный запрос')));
    }

    private function handleMutation($query, $variables) {

        if (preg_match('/createUser\s*\(\s*name\s*:\s*"([^"]+)"\s*\)\s*\{([^}]+)\}/', $query, $matches)) {
            $name = $matches[1];
            $fields = $this->parseFields($matches[2]);

            $createdUser = $this->user->create($name);

            if ($createdUser) {
                $result = array();
                foreach ($fields as $field) {
                    if (isset($createdUser[$field])) {
                        $result[$field] = $createdUser[$field];
                    }
                }
                return array('data' => array('createUser' => $result));
            } else {
                return array(
                    'data' => array('createUser' => null),
                    'errors' => array(array('message' => 'Ошибка при создании пользователя'))
                );
            }
        }

        return array('errors' => array(array('message' => 'Неизвестная мутация')));
    }

    private function parseFields($fieldsString) {
        $fields = array();
        $fieldsString = trim($fieldsString);
        $fieldParts = preg_split('/\s+/', $fieldsString);

        foreach ($fieldParts as $field) {
            $field = trim($field);
            if (!empty($field)) {
                $fields[] = $field;
            }
        }

        return $fields;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['query'])) {
        echo json_encode(array(
            'errors' => array(array('message' => 'Query не предоставлен'))
        ), JSON_UNESCAPED_UNICODE);
        exit;
    }

    $parser = new SimpleGraphQLParser($user);
    $result = $parser->execute($input['query'], isset($input['variables']) ? $input['variables'] : null);

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>GraphQL Playground</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            textarea { width: 100%; height: 200px; margin: 10px 0; }
            button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
            .result { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; }
        </style>
    </head>
    <body>
    <h1>GraphQL Playground</h1>

    <h3>Примеры запросов:</h3>

    <h4>1. Получить всех пользователей:</h4>
    <pre>{ users { id name } }</pre>

    <h4>2. Получить пользователя по ID:</h4>
    <pre>{ getUser(id: 1) { id name } }</pre>

    <h4>3. Создать пользователя:</h4>
    <pre>mutation { createUser(name: "Мария") { id name } }</pre>

    <textarea id="query" placeholder="Введите GraphQL запрос...">{ users { id name } }</textarea>
    <br>
    <button onclick="executeQuery()">Выполнить запрос</button>

    <div id="result" class="result"></div>

    <script>
        function executeQuery() {
            const query = document.getElementById('query').value;

            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ query: query })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(error => {
                    document.getElementById('result').innerHTML = '<pre>Ошибка: ' + error + '</pre>';
                });
        }
    </script>
    </body>
    </html>
    <?php
}
?>