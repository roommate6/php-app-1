<?php

declare(strict_types=1);

use App\App;
use App\Services\ConfigurationService;
use App\Controllers\HomeController;
use App\Controllers\TransactionsController;
use App\Services\RouterService;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new RouterService();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/transactions', [TransactionsController::class, 'index'])
    ->get('/transactions/upload', [TransactionsController::class, 'getUpload'])
    ->post('/transactions/upload', [TransactionsController::class, 'postUpload']);

(new App(
    $router,
    new ConfigurationService($_ENV),
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
))->run();
