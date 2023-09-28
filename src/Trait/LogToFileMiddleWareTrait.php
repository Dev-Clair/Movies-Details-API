<?php

declare(strict_types=1);

namespace src\Trait;

trait LogToFileMiddleWareTrait
{
    public function logToFile(array $data): void
    {
        $logFilePath = __DIR__ . '/../../logs/app.log';
        $logData = $data;

        file_put_contents($logFilePath, $logData, FILE_APPEND);
    }
}
