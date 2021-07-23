<?php
/**
 * Class AuthController
 * @package app\Controllers
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */


namespace app\Controllers;
use app\Core\Application;
use app\core\Controller;
use app\core\Request;
use app\Models\User;

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
        $registerModel = new User();
        $this->setLayout('auth');
        return $this->render('register',[
            'model' => $registerModel
        ]);
    }

    public function handleRegister(Request $request)
    {
        $user = new User();
        $user->loadData($request->getBody());

        if($user->validate() && $user->save()){
            Application::$app->session->setFlush('success','Thanks for registering');
            Application::$app->response->redirect('/');
        }
        return $this->render('register',[
            'model' => $user
        ]);
    }
}