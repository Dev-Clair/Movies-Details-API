<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\MovieModel;

class MovieController extends AbsController
{
    public function __construct()
    {
        $movieModel = new MovieModel(databaseName: "movies");

        parent::__construct($movieModel);
    }

    public function index()
    {
    }
}
