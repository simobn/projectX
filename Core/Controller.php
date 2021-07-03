<?php
/**
 * Class Controller
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\core;
class Controller
{
    public function render($view , $params = [])
    {
        return Application::$app->router->renderView($view , $params);
    }
}