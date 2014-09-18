<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
														 'id' => 'login-form',
														 'enableClientValidation' => true,
														 'clientOptions' => array(
															 'validateOnSubmit' => true,
														 ),
													)); ?>

	<div class="auto">
		<p>Логин:</p>

		<p>
			<?php
			echo $form->textField($model, 'username');
			echo $form->error($model, 'username');
			?>
		</p>

		<p>Пароль:</p>

		<p>
			<?php
			echo $form->passwordField($model, 'password');
			echo $form->error($model, 'password');
			?>
		</p>

		<p>
			<?php echo $form->checkBox($model, 'rememberMe', array('class' => 'check')); ?>
			Запомнить меня
			<?php echo $form->error($model, 'rememberMe'); ?>
		</p>

		<p class="go">
			<input type="submit" value="">
		</p>

		<p><a href="/admin/remember">Напомнить пароль</a></p>
	</div>


	<?php $this->endWidget(); ?>
</div>
