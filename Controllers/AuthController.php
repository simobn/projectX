<?php
/**
 * Class AuthController
 * @package app\Controllers
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */


namespace app\Controllers;
use app\core\Controller;
use app\core\Request;
use app\Models\RegisterModel;

class AuthController extends Controller
{

    public function login(){
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function handleLogin(Request $request)
    {
        var_dump($request->getBody());
    }

    public function register()
    {
        $registerModel = new RegisterModel();
        $this->setLayout('auth');
        return $this->render('register',[
            'model' => $registerModel
        ]);
    }

    public function handleRegister(Request $request)
    {
        $registerModel = new RegisterModel();
        $registerModel->loadData($request->getBody());

        if($registerModel->validate() && $registerModel->register()){
            return 'success';
        }
        return $this->render('register',[
            'model' => $registerModel
        ]);
    }
}