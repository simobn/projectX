<?php
/**
 * Class View
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core;
class View
{

    public string $title = '';

    public function renderView(string $view ,$params=[])
    {
        $viewContent = $this->renderOnlyView($view , $params);
        $layout = $this->getLayout();
        return str_replace('{{content}}',$viewContent,$layout);
    }

    private function renderContent($viewContent)
    {
        $layout = $this->getLayout();
        return str_replace('{{content}}',$viewContent,$layout);
    }

    protected function getLayout()
    {
        $layout = Application::$app->layout;
        if($layout = Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
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