<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use App\Services\ConfigurationService;
use App\Services\DatabaseService;
use App\Services\RouterService;
use App\Services\ViewService;

class App
{
    private static DatabaseService $_databaseService;
    protected RouterService $_routerService;
    protected ConfigurationService $_configurationService;

    protected array $_request;

    public function __construct(
        protected RouterService $routerService,
        ConfigurationService $configurationService,
        protected array $request
    ) {
        $this->_routerService = $routerService;
        $this->_configurationService = $configurationService;
        $this->_request = $request;

        static::$_databaseService
            = new DatabaseService($this->_configurationService->database ?? []);
    }

    public static function getDatabaseService(): DatabaseService
    {
        return static::$_databaseService;
    }

    public function run()
    {
        try {
            echo $this->_routerService->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo ViewService::make(['Errors', '404'])->render();
        }
    }
}
