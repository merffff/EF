#!/bin/bash


if lsof -Pi :8020 -sTCP:LISTEN -t >/dev/null 2>&1; then
    PORT=8001
else
    PORT=8020
fi

BASE_URL="http://localhost:$PORT"

echo "🚀 Тестирование REST API"
echo "========================="
echo "🌐 Базовый URL: $BASE_URL"

echo ""
echo "📋 Задание 1: GET /users - получить список пользователей"
curl -X GET "$BASE_URL/api/users"
echo -e "\n"

echo ""
echo "➕ Задание 2: POST /users - создать пользователя"
curl -X POST -H "Content-Type: application/json" -d '{"name": "Иван"}' "$BASE_URL/api/users"
echo -e "\n"

echo ""
echo "✏️ Задание 3: PUT /users/1 - обновить пользователя"
curl -X PUT -H "Content-Type: application/json" -d '{"name": "Алексей"}' "$BASE_URL/api/users/1"
echo -e "\n"

echo ""
echo "🔍 Проверяем список после обновления"
curl -X GET "$BASE_URL/api/users"
echo -e "\n"

echo ""
echo "🗑️ Задание 4: DELETE /users/1 - удалить пользователя"
curl -X DELETE "$BASE_URL/api/users/1"
echo -e "\n"

echo ""
echo "🔧 GraphQL Tests"
echo "================"

echo ""
echo "📋 Задание 5: GraphQL - получить список пользователей"
curl -X POST -H "Content-Type: application/json" -d '{"query": "{ users { id name } }"}' "$BASE_URL/graphql"
echo -e "\n"

echo ""
echo "🔍 Задание 6: GraphQL - получить пользователя по ID"
curl -X POST -H "Content-Type: application/json" -d '{"query": "{ getUser(id: 2) { id name } }"}' "$BASE_URL/graphql"
echo -e "\n"

echo ""
echo "➕ Задание 7: GraphQL - создать пользователя"
curl -X POST -H "Content-Type: application/json" -d '{"query": "mutation { createUser(name: \"Мария\") { id name } }"}' "$BASE_URL/graphql"
echo -e "\n"

echo ""
echo "📋 Финальный список пользователей через GraphQL"
curl -X POST -H "Content-Type: application/json" -d '{"query": "{ users { id name created_at } }"}' "$BASE_URL/graphql"
echo -e "\n"

echo ""
echo "✅ Все тесты выполнены!"
echo ""
echo "🌐 Откройте в браузере: $BASE_URL/graphql для GraphQL Playground"