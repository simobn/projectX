<?php
/**
 * Class ForbiddenException
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core\Exceptions;
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}