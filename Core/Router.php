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
            return 'not found';
        }
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        echo call_user_func($callback);
    }

    private function renderView(string $view)
    {
        //replace the layoutContent method
        $layout = $this->getLayout();
        $viewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}',$viewContent,$layout);
    }

    protected function getLayout()
    {
        ob_start();
        require_once Application::$ROOT_DIR."/Views/layouts/main.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view)
    {
        ob_start();
        require_once Application::$ROOT_DIR."/Views/$view.php";
        return ob_get_clean();
    }
}