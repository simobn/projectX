<?php
/**
 * Class Field
 * @package app\Core\Form
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core\Form;
use app\Core\Model;

class InputField extends BaseField
{
    public const TEXT_FIELD = 'text';
    public const EMAIL_FIELD = 'email';
    public const PASSWORD_FIELD = 'password';



    public string $type;

    public function __construct(Model $model,$attribute)
    {
        $this->type = self::TEXT_FIELD;
        parent::__construct($model,$attribute);
    }


    public function passwordField()
    {
        $this->type = self::PASSWORD_FIELD;
        return $this;
    }

    public function emailField()
    {
        $this->type = self::EMAIL_FIELD;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s"  name="%s" value="%s" class="form-control %s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
        );
    }
}