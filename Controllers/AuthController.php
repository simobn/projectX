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
use app\core\Response;
use app\Models\loginForm;
use app\Models\User;

class AuthController extends Controller
{

    public function login(){
        $loginForm = new loginForm();
        $this->setLayout('auth');
        return $this->render('login',[
            'model' => $loginForm
        ]);
    }

    public function logout(Request $request , Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }

    public function handleLogin(Request $request , Response $response)
    {
        $loginForm = new loginForm();
        $loginForm->loadData($request->getBody());
        if($loginForm->validate() && $loginForm->login()){
            $response->redirect('/');
            return;
        }
        $this->setLayout('auth');
        return $this->render('login',[
            'model' => $loginForm
        ]);
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