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
    public const RULE_UNIQUE = 'unique';

    public function loadData($data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }


    abstract public function rules():array;

    public function labels():array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }
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
                    $this->addErrorForRule($attribute , self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute , self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute , self::RULE_MIN,$rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute , self::RULE_MAX , $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute , self::RULE_MATCH , $rule);
                }
                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr",$value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record){
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE ,['field' => $this->getLabel($attribute)]);
                    }
                }

            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][] =   $message;
    }
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] =   $message;
    }

    public function errorMessages():array
    {
        return [
            self::RULE_REQUIRED =>  'this field is required',
            self::RULE_EMAIL    =>  'this field must be a valid email',
            self::RULE_MAX      =>  'the max length of this field is {max}',
            self::RULE_MIN      =>  'the min length of this field is {min}',
            self::RULE_MATCH    =>  'this field must match {match} field',
            self::RULE_UNIQUE    =>  'record already exist with this {field}',
        ];
    }

    public function hasError(string $attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError(string $attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

}