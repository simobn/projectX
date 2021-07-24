<?php
/**
 * Class Session
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\core;
class Session
{

    protected const FLASH_KEY = 'flash_messages' ?? [];

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

        foreach ($flashMessages as $key => &$flashMessage){
            //mark as to be removed
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function setFlush($key , $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove'   => false,
            'value'     => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key , $value){
        $_SESSION[$key] = $value;
    }

    public function get($key){
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }
    public function __destruct()
    {
        // remove to be removed
        $flashMessages = $_SESSION[self::FLASH_KEY];

        foreach ($flashMessages as $key => &$flashMessage){
            //mark as to be removed
           if($flashMessage['remove']){
               unset($flashMessages[$key]);
           }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}