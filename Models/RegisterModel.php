<?php
/**
 * Class RegisterModel
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Models;
use app\Core\Model;

class RegisterModel extends Model
{
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirmPassword;

    public function register()
    {
        echo 'create new record';
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED ,[self::RULE_MIN ,'min'=> 8],[self::RULE_MAX , 'max' => 20]],
            'confirmPassword' => [self::RULE_REQUIRED , [self::RULE_MATCH,'match'=> 'password']],
        ];
    }
}