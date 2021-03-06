<?php
/**
 * Class RegisterModel
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Models;
//use app\Core\DbModel;
//use app\Core\Model;
use app\Core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $firstname    =   '';
    public string $lastname =   '';
    public string $email    =   '';
    public int $status    =   self::STATUS_INACTIVE;
    public string $password =   '';
    public string $confirmPassword  =   '';


    public function tableName(): string
    {
        return 'users';
    }

    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
        return 'id';
    }

    public function getDisplayName(): string
    {
        // TODO: Implement getDisplayName() method.
        return "$this->firstname $this->lastname";
    }

    public function attributes(): array
    {
        return ['firstname','lastname','email','password','status'];
    }

//    public function save()
//    {
////        this->$this->password = pass
//        return parent::save();
//    }

    public function labels(): array
    {
        return [
            'firstname'         =>  'First name',
            'lastname'          =>  'Last name',
            'email'             =>  'Email',
            'password'          =>  'Password',
            'confirmPassword'   =>  'Confirm password'
        ];
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL ,[self::RULE_UNIQUE,'class' => self::class]],
            'password' => [self::RULE_REQUIRED ,[self::RULE_MIN ,'min'=> 8],[self::RULE_MAX , 'max' => 20]],
            'confirmPassword' => [self::RULE_REQUIRED , [self::RULE_MATCH,'match'=> 'password']],
        ];
    }
}