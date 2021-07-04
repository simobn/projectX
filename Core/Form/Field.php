<?php
/**
 * Class Field
 * @package app\Core\Form
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */
namespace app\Core\Form;
use app\Core\Model;

class Field
{
    public const TEXT_FIELD = 'text';
    public const EMAIL_FIELD = 'email';
    public const PASSWORD_FIELD = 'password';


    public Model $model;
    public string $attribute;
    public string $type;

    public function __construct(Model $model,$attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TEXT_FIELD;
    }

    public function __toString()
    {
        return sprintf('
                <div class="mb-3">
                    <label for="%s" class="form-label">%s</label>
                    <input type="%s"  name="%s" value="%s" class="form-control %s">
                </div>
                <div class="invalid-feedback" style="display: block!important;">
                    %s
                </div>
                ',
            $this->attribute,
                $this->attribute,
                $this->type,
                $this->attribute,
                $this->model->{$this->attribute},
                $this->model->hasError($this->attribute) ? 'is-invalid' : '',
                $this->model->getFirstError($this->attribute)
        );
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
}