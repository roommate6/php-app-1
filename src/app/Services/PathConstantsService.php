<?php

declare(strict_types=1);

namespace App\Services;

class PathConstantsService
{
    public static string $VIEWS_PATH = __DIR__ . '/../Views';
    public static string $TRANSACTION_FILES_PATH = __DIR__ . '/../../transaction_files';

    private function __construct()
    {
    }
}
