<?php

use Swoole\Timer;

echo "🕐 Swoole Timer Server запущен!\n";
echo "📝 Версия Swoole: " . SWOOLE_VERSION . "\n";
echo "🐘 Версия PHP: " . PHP_VERSION . "\n";
echo "⏰ Таймер будет срабатывать каждые 5 секунд...\n";
echo "--- Нажмите Ctrl+C для остановки ---\n\n";


$messageCount = 0;


$timerId = Timer::tick(5000, function () use (&$messageCount) {
    $messageCount++;
    $timestamp = date('Y-m-d H:i:s');

    echo "🔔 [{$timestamp}] Сообщение #{$messageCount} - Таймер сработал каждые 5 секунд!\n";
    echo "   💡 Process ID: " . getmypid() . "\n";
    echo "   ⚡ Memory usage: " . round(memory_get_usage() / 1024 / 1024, 2) . " MB\n";
    echo "   ---\n";


    flush();
});

echo "✅ Таймер #{$timerId} создан успешно!\n";
echo "⏱️  Ожидаем первого срабатывания через 5 секунд...\n\n";


Swoole\Event::wait();
