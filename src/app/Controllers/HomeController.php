<?php

declare(strict_types=1);

namespace App\Controllers;

use \App\Services\ViewService;

class HomeController
{
    public function index(): string
    {
        return ViewService::make(['Index'])->render();
    }
}
