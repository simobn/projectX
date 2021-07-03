<?php
/**
 * Class AuthController
 * @package app\Controllers
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */


namespace app\Controllers;
use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{

    public function login(){
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function handleLogin(Request $request)
    {
        var_dump($request->getBoy());
    }

    public function register()
    {
        $this->setLayout('auth');
        return $this->render('register');
    }

    public function handleRegister(Request $request)
    {
        var_dump($request->getBoy());
    }
}