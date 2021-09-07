<?php
/**
 * Class BaseMiddleware
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core\Middlewares;
abstract class BaseMiddleware
{

    abstract public function execute();
}