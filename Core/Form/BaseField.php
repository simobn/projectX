<?php
namespace app\Core\Form;
use app\Core\Model;

/**
 * Class BaseField
 * @package app\Core\Form
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

abstract class BaseField
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model,$attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    abstract public function renderInput() : string;

    public function __toString()
    {
        return sprintf('
                <div class="mb-3">
                    <label for="%s" class="form-label">%s</label>
                    %s
                </div>
                <div class="invalid-feedback" style="display: block!important;">
                    %s
                </div>
                ',
            $this->attribute,
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

}