<?php

declare(strict_types=1);

namespace App\Repositories;

use \App\Services\DatabaseService;
use \App\App;

abstract class BaseRepository
{
    protected DatabaseService $_databaseService;

    public function __construct()
    {
        $this->_databaseService = App::getDatabaseService();
    }

    public abstract function create(object $model): bool;
    public abstract function getById(int $id): ?object;
    public abstract function getAll(): array;
}
