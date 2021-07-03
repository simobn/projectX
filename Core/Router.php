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
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback == false){
            $this->response->setStatusCode(404);
            return $this->renderContent('not found');
        }
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        if (is_array($callback)){
            $callback[0] = new $callback[0]();
        }
        return call_user_func($callback , $this->request);
    }

    public function renderView(string $view ,$params=[])
    {
        //replace the layoutContent method
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
        ob_start();
        require_once Application::$ROOT_DIR."/Views/layouts/main.php";
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