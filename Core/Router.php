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
    public Response $response;

    public function __construct(Request $request,Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post(string $path,$callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback == false){
            $this->response->setStatusCode(404);
            return $this->renderContent('not found');
        }
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        if (is_array($callback)){
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        return call_user_func($callback , $this->request , $this->response);
    }

    public function renderView(string $view ,$params=[])
    {
        $layout = $this->getLayout();
        $viewContent = $this->renderOnlyView($view , $params);
        return str_replace('{{content}}',$viewContent,$layout);
    }

    private function renderContent($viewContent)
    {
        $layout = $this->getLayout();
        return str_replace('{{content}}',$viewContent,$layout);
    }

    protected function getLayout()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        require_once Application::$ROOT_DIR."/Views/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view , $params = [])
    {
        foreach ($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        require_once Application::$ROOT_DIR."/Views/$view.php";
        return ob_get_clean();
    }
}