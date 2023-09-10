<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\MovieModel;

abstract class AbsController implements IntController
{
    protected MovieModel $movieModel;

    public function __construct(MovieModel $movieModel = null)
    {
        $this->movieModel = $movieModel ?: new $movieModel(databaseName: "movies");
    }
    abstract public function index();

    protected function sanitizeUserInput(): array
    {
        $sanitizedInput = [];
        foreach ($_POST as $fieldName => $userInput) {
            $sanitizedInput[$fieldName] = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $sanitizedInput;
    }
}
