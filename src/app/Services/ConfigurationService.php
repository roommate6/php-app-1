<?php

declare(strict_types=1);

namespace App\Services;

/**
 * @property-read ?array $database
 */
class ConfigurationService
{
    protected array $_configuration = [];

    public function __construct(array $env)
    {
        $this->_configuration = [
            'database' => [
                'host'     => $env['DB_HOST'],
                'user'     => $env['DB_USER'],
                'pass'     => $env['DB_PASS'],
                'name'     => $env['DB_NAME'],
                'driver'   => $env['DB_DRIVER'] ?? 'mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->_configuration[$name] ?? null;
    }
}
