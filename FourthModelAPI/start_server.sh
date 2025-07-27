#!/bin/bash

echo "🚀 Запуск встроенного PHP сервера..."
echo "=================================="


if ! command -v php &> /dev/null; then
    echo "❌ PHP не найден. Пожалуйста, установите PHP."
    exit 1
fi


echo "📋 Версия PHP: $(php -v | head -n 1)"


if lsof -Pi :8000 -sTCP:LISTEN -t >/dev/null 2>&1; then
    echo "⚠️  Порт 8020 уже занят. Попробуем порт 8001..."
    PORT=8001
else
    PORT=8020
fi

echo ""
echo "🌐 Сервер будет доступен по адресу: http://localhost:$PORT"
echo ""
echo "📍 Доступные эндпоинты:"
echo "   REST API: http://localhost:$PORT/api/users"
echo "   GraphQL:  http://localhost:$PORT/graphql"
echo ""
echo "⏹️  Для остановки сервера нажмите Ctrl+C"
echo ""


php -S localhost:$PORT router.php