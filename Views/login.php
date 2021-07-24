<?php
/*
 * @var $model \app\Models\User
 * */
?>

<h1>Login</h1>
<?php $form = \app\Core\Form\Form::begin('','post')?>
    <?php echo $form->field($model , 'email')->emailField()?>
    <?php echo $form->field($model , 'password')->passwordField()?>

    <?php echo $form->submit('Login')?>
<?php echo \app\Core\Form\Form::end()?>

