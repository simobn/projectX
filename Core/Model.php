<?php
/**
 * Class Model
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core;
abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }


    abstract public function rules():array;

    public array $errors = [];
    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute , self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $this->addError($attribute , self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addError($attribute , self::RULE_MIN,$rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addError($attribute , self::RULE_MAX , $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $this->addError($attribute , self::RULE_MATCH , $rule);
                }

            }
        }
        return empty($this->errors);
    }

    private function addError(string $attribute, string $rule,$params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][] =   $message;
    }

    public function errorMessages():array
    {
        return [
            self::RULE_REQUIRED =>  'this field is required',
            self::RULE_EMAIL    =>  'this field must be a valid email',
            self::RULE_MAX      =>  'the max length of this field is {max}',
            self::RULE_MIN      =>  'the min length of this field is {min}',
            self::RULE_MATCH    =>  'this field must match {match} field'
        ];
    }

}