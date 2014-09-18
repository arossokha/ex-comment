<div id="filter">

	<?php $form = $this->beginWidget('CActiveForm', array(
														 'id' => 'feedback-form',
														 'enableAjaxValidation' => false,
													));
	?>
	<div>
		<div class="text">
			<h5>Информация!</h5>

			<p>
				Уважаемые пользователи!
			</p>

			<p>
				Нам очень важно Ваше мнение, поэтому будьте добры оставлять только объективные отзывы. По возможности
				постарайтесь объяснить почему вам понравился или не понравился сайт.
			</p>

			<p>
				Спасибо!
			</p>
		</div>
		<table>

			<?php
			if ( Yii::app()->user->isGuest ) {
				?>
				<tr>
					<td>
						<p>Напишите отзыв о сайте</p>
					</td>
				</tr>
				<tr>
					<td>Имя<strong>*</strong></td>
					<td class="full">
						<?php
						echo $form->textField($model, 'name', array('style' => 'width:300px'));
						echo $form->error($model, 'name');
						?>
					</td>
				</tr>
				<tr>
					<td>E-mail<strong>*</strong></td>
					<td class="full">
						<?php
						echo $form->textField($model, 'email', array('style' => 'width:300px'));
						echo $form->error($model, 'email');
						?>

					</td>
				</tr>
				<?php
			} else {
				?>
				<tr>
					<td><?php
						$u = Yii::app()->user->getModel();
						echo $u->getName();
						?>
						<p>Напишите отзыв о сайте</p>
					</td>
				</tr>

				<?php
			}
			?>

			<tr>
				<td>Сообщение<strong>*</strong></td>
				<td class="full">
					<?php
					echo $form->textArea($model, 'message', array('style' => 'width: 300px;'));
					echo $form->error($model, 'message');
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><p>Все поля отмеченные (<strong>*</strong>) обязательны к заполнению</p></td>
			</tr>
			<tr>
				<td></td>
				<td class="go reg"><input type="submit" value="Отправить сообщение "></td>
			</tr>

		</table>
	</div>
	<?php $this->endWidget();
	//var_dump($model->getErrors());
	?>

</div>
