<?php

declare(strict_types=1);

namespace src\Trait;

trait ResponseLogTrait
{
    public function responseLog(array $data): void
    {
        $logFilePath = __DIR__ . '/../../logs/response.log';
        $logData = json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;

        file_put_contents($logFilePath, $logData, FILE_APPEND);
    }
}
