<?php

declare(strict_types=1);

namespace src\Controller;

abstract class AbsController implements IntController
{
    protected function sanitizeData(): array
    {
        $sanitizedData = [];
        foreach ($_POST as $postField => $postValue) {
            $sanitizedData[$postField] = filter_var($postValue, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $sanitizedData;
    }
}
