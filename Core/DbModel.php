<?php
/**
 * Class DbModel
 * @package app\Core
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core;

abstract class DbModel extends Model
{
    abstract public function tableName():string;

    abstract public function attributes(): array;

    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr)=> ":$attr",$attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',',$attributes).") 
                                    VALUES (".implode(',',$params).");");
        foreach ($attributes as $attribute){
            if ($attribute === "password"){
                $this->{$attribute} = password_hash($this->{$attribute},PASSWORD_DEFAULT);
            }
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    public static function prepare($sql){
        return  Application::$app->db->prepare($sql);
    }
}