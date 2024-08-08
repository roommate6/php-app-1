<?php

declare(strict_types=1);

namespace App\Services;

use \App\Exceptions\ViewNotFoundException;
use \InvalidArgumentException;

class ViewService
{
    protected array $_viewPath;
    protected array $_params;

    public function __construct(
        array $viewPath,
        array $params = []
    ) {
        if (sizeof($viewPath) === 0) {
            throw new InvalidArgumentException('View path should have at least one element.');
        }

        $this->_viewPath = $viewPath;
        $this->_params = $params;
    }

    public static function make(array $viewPath, array $params = []): static
    {
        return new static($viewPath, $params);
    }

    public function render(): string
    {
        $viewPath = PathConstantsService::$VIEWS_PATH;
        foreach ($this->_viewPath as $item) {
            $viewPath .= '/' . $item;
        }

        $viewPath .= '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        foreach ($this->_params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include $viewPath;

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name)
    {
        return $this->_params[$name] ?? null;
    }
}
