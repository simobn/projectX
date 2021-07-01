<?php
/**
 * Class Router
 * @namespace app\Core;
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core;
class Router
{
    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback == false){
            echo 'not found';
            exit();
        }
        echo call_user_func($callback);
    }
}