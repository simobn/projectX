<?php
/**
 * Class AuthMiddleware
 * @package app\Core\Middlewares
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core\Middlewares;
use app\Core\Application;
use app\Core\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{

    public array $actions = [];

    public function __construct(array $actions=[])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()){
            if (empty($this->actions) || in_array(Application::$app->controller->action ,$this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}