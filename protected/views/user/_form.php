<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
														 'id' => 'user-form',
														 'enableAjaxValidation' => false,
													)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 20)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'lastName'); ?>
		<?php echo $form->textField($model, 'lastName', array('size' => 20, 'maxlength' => 20)); ?>
		<?php echo $form->error($model, 'lastName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
		<?php echo $form->error($model, 'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'login'); ?>
		<?php echo $form->textField($model, 'login', array('size' => 50, 'maxlength' => 50)); ?>
		<?php echo $form->error($model, 'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password', array('size' => 40, 'maxlength' => 40)); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('size' => 60, 'maxlength' => 100)); ?>
		<?php echo $form->error($model, 'salt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'role'); ?>
		<?php echo $form->textField($model, 'role'); ?>
		<?php echo $form->error($model, 'role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'active'); ?>
		<?php echo $form->textField($model, 'active'); ?>
		<?php echo $form->error($model, 'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'updated_timestamp'); ?>
		<?php echo $form->textField($model, 'updated_timestamp'); ?>
		<?php echo $form->error($model, 'updated_timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'created_timestamp'); ?>
		<?php echo $form->textField($model, 'created_timestamp'); ?>
		<?php echo $form->error($model, 'created_timestamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->