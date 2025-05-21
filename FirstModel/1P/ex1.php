<?php

function getStatusMessage( string $status)
{
    return match ($status) {
        'success' => 'Операция выполнена успешно',
        'error'=> 'Произошла ошибка ',
        'pending'=> 'Операция в ожидании',
        default=> 'Неизвестный статус'
    };

}

echo getStatusMessage('success')."\n";
echo getStatusMessage('error')."\n";
echo getStatusMessage('pending')."\n";
echo getStatusMessage('unknown');

