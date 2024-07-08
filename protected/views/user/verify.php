<?php
$this->pageTitle = Yii::app()->name . ' - Verify Email';
$this->breadcrumbs = array(
    'Verify Email',
);
?>

<h1>Verify Email</h1>

<?php if(Yii::app()->user->hasFlash('success')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<p>Please enter your verification token to verify your email:</p>

<div class="form">
<?php echo CHtml::beginForm(); ?>

    <div class="row">
        <?php echo CHtml::textField('token', '', array('placeholder' => 'Enter verification token')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Verify'); ?>
    </div>

<?php echo CHtml::endForm(); ?>
</div>
