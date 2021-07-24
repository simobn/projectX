<?php
/**
 * Class loginForm
 * @package app\Models
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Models;
use app\Core\Application;
use app\Core\Model;

class loginForm extends Model
{

    public string $email = '';
    public string $password = '';
    public function rules(): array
    {
        return  [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Email',
            'password'  => 'Password'
        ];
    }

    public function login()
    {
        $user = (new User())->findOne(['email' => $this->email]);
        if(!$user){
            $this->addError('email','No record exists with this email');
            return false;
        }
        if (!password_verify($this->password,$user->password)){
            $this->addError('password','password or email is incorrect');
            return false;
        }
        return Application::$app->login($user);
    }
}