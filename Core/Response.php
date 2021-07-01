<?php
/**
 * Class Response
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\core;
class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}