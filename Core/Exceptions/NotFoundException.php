<?php
/**
 * Class NotFoundException
 * @package app\Core\Exceptions
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core\Exceptions;
class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}