<?php

declare(strict_types=1);

namespace App\Services;

use \PDO;
use \PDOException;

/**
 * @mixin PDO
 */
class DatabaseService
{
    private PDO $_pdo;

    public function __construct(array $configuration)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->_pdo = new PDO(
                $configuration['driver'] . ':host=' .
                    $configuration['host'] . ';dbname=' .
                    $configuration['name'],
                $configuration['user'],
                $configuration['pass'],
                $configuration['options'] ?? $defaultOptions
            );
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->_pdo, $name], $arguments);
    }
}
