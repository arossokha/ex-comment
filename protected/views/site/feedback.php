<h1>Обратная связь</h1>

<div id="filter">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
														 'id' => 'feedback-form',
														 'enableAjaxValidation' => false,
													));
	?>
	<div>
		<table>

			<?php
			if ( Yii::app()->user->isGuest ) {
				?>
				<tr>
					<td>ФИО<strong>*</strong></td>
					<td class="full">
						<?php
						echo $form->textField($model, 'name', array('style' => 'width:255px'));
						echo $form->error($model, 'name');
						?>
					</td>
				</tr>
				<tr>
					<td>E-mail<strong>*</strong></td>
					<td class="full">
						<?php
						echo $form->textField($model, 'email', array('style' => 'width:255px'));
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
					</td>
				</tr>

				<?php
			}
			?>

			<tr>
				<td>Тема<strong>*</strong></td>
				<td class="size1">
					<?php
					echo $form->dropDownList($model, 'title',
						array(
							 'Сообщение об ошибке' => 'Сообщение об ошибке',
							 'Сообщение по рекламе' => 'Сообщение по рекламе',
							 'Сообщение о сотрудничестве' => 'Сообщение о сотрудничестве',
							 'Другое' => 'Другое'
						),
						array('class' => 'custom','style' => 'width: 255px;'));
					echo $form->error($model, 'title');
					?>
				</td>
			</tr>
			<tr>
				<td>Сообщение<strong>*</strong></td>
				<td class="full">
					<?php
					echo $form->textArea($model, 'message', array('style' => 'width: 255px;',
															'rows' => '10'));
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
