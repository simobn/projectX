<?php
/**
 * Class Form
 * @package app\core\Form
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

namespace app\Core\Form;
use app\Core\Model;

class Form
{
    public static function begin(string $action,string $method):Form
    {
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new Form();
    }
    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model,$attribute)
    {
        return new Field($model,$attribute);
    }

    public function submit(string $label):string{
        return sprintf('<button type="submit" class="btn btn-primary">%s</button>',$label);
    }

}