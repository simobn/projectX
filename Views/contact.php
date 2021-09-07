<?php
/** @var $model ContactForm **/

use app\Core\Form\Form;
use app\core\Form\TextareaField;
use app\Models\ContactForm;

$this->title = 'contact';
?>

<h1>contact</h1>
<?php $form = Form::begin('','post')?>
<?php echo $form->field($model , 'subject')?>
<?php echo $form->field($model , 'email')?>
<?php echo new TextareaField($model,'body')?>
<?php echo $form->submit('send')?>
<?php Form::end();?>
