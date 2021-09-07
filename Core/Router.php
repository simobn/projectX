<?php
/**
 * Class Router
 * @namespace app\Core;
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core;
use app\Core\Exceptions\NotFoundException;

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
            throw new NotFoundException();
        }
        if(is_string($callback)){
            return Application::$app->view->renderView($callback);
        }
        if (is_array($callback)){
            /**@var Controller $controller*/
            $controller  = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }
        return call_user_func($callback , $this->request , $this->response);
    }

//    public function renderView(string $view ,$params=[])
//    {
//        return Application::$app->view->renderView($view , $params);
//    }
//
//    private function renderContent($viewContent)
//    {
//        $layout = $this->getLayout();
//        return str_replace('{{content}}',$viewContent,$layout);
//    }

//    protected function getLayout()
//    {
//        $layout = Application::$app->layout;
//        if($layout = Application::$app->controller){
//            $layout = Application::$app->controller->layout;
//        }
//        ob_start();
//        require_once Application::$ROOT_DIR."/Views/layouts/$layout.php";
//        return ob_get_clean();
//    }
//    protected function renderOnlyView($view , $params = [])
//    {
//        foreach ($params as $key => $value){
//            $$key = $value;
//        }
//        ob_start();
//        require_once Application::$ROOT_DIR."/Views/$view.php";
//        return ob_get_clean();
//    }
}