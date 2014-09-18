<?php
/**
 * Remember password view
 * @todo : add correct login here show correct messages
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */

?>

<p class="back">
	<a href="<?php echo (Yii::app()->user->returnUrl ? Yii::app()->user->returnUrl : '/admin'); ?>">назад</a>
</p>
<div class="auto">
	<?php $form = $this->beginWidget('CActiveForm', array(
														 'id' => 'remember-form',
														 'enableClientValidation' => true,
														 'clientOptions' => array(
															 'validateOnSubmit' => true,
														 ),
													));
	?>
	<p>Ваш e-mail:</p>

	<p>
		<input name="email" type="text">
	</p>

	<p class="send">
		<input type="submit" value="">
	</p>
	<?php $this->endWidget(); ?>
</div>