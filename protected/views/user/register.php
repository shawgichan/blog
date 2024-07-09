<?php
$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Register</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'register-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        'validateOnType'=>false,
    ),
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'passwordConfirm'); ?>
        <?php echo $form->passwordField($model,'passwordConfirm'); ?>
        <?php echo $form->error($model,'passwordConfirm'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Register'); ?>
    </div>

<?php $this->endWidget(); ?>
<?php
Yii::app()->clientScript->registerScript('email-check', "
    $('#RegisterForm_email').blur(function(){
        $.ajax({
            url: '".Yii::app()->createUrl('user/validateEmail')."',
            type: 'POST',
            data: {RegisterForm: {email: $(this).val()}},
            dataType: 'json',
            success: function(data) {
                if(data.RegisterForm_email) {
                    $('#RegisterForm_email_em_').html(data.RegisterForm_email[0]).show();
                } else {
                    $('#RegisterForm_email_em_').hide();
                }
            }
        });
    });
");
?>
</div><!-- form -->
