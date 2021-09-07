<?php
/**
 * Class Controller
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\core;
use app\Core\Middlewares\BaseMiddleware;

class Controller
{

    /*
     * @var \app\Core\Middlewares\BaseMiddleware[]
     * */
    protected array $middlewares = [];
    public string $action = '';
    public string $layout = 'main';
    public function render($view , $params = [])
    {
        return Application::$app->view->renderView($view , $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param array $middlewares
     */
    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }
}