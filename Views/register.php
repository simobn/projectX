<?php
/*
 * @var $model \app\Models\User
 * */
?>

<h1>register</h1>
<?php $form = \app\Core\Form\Form::begin('','post')?>
    <?php echo $form->field($model , 'firstname')?>
    <?php echo $form->field($model , 'lastname')?>
    <?php echo $form->field($model , 'email')->emailField()?>
    <?php echo $form->field($model , 'password')->passwordField()?>
    <?php echo $form->field($model , 'confirmPassword')->passwordField()?>

    <?php echo $form->submit('register')?>
<?php echo \app\Core\Form\Form::end()?>

