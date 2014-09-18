<div class="wide form">

	<?php $form = $this->beginWidget('CActiveForm', array(
														 'action' => Yii::app()->createUrl($this->route),
														 'method' => 'get',
													)); ?>

	<div class="row">
		<?php echo $form->label($model, 'userId'); ?>
		<?php echo $form->textField($model, 'userId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size' => 20, 'maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'lastName'); ?>
		<?php echo $form->textField($model, 'lastName', array('size' => 20, 'maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('size' => 20, 'maxlength' => 20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'email'); ?>
		<?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'login'); ?>
		<?php echo $form->textField($model, 'login', array('size' => 50, 'maxlength' => 50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'salt'); ?>
		<?php echo $form->textField($model, 'salt', array('size' => 60, 'maxlength' => 100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'role'); ?>
		<?php echo $form->textField($model, 'role'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'active'); ?>
		<?php echo $form->textField($model, 'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'updated_timestamp'); ?>
		<?php echo $form->textField($model, 'updated_timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'created_timestamp'); ?>
		<?php echo $form->textField($model, 'created_timestamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- search-form -->