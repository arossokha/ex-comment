<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>
<h1>Регистрация</h1>
<?php $form = $this->beginWidget('CActiveForm', array(
													 'id' => 'user-form',
													 'enableAjaxValidation' => false,
												));
?>
		<?php
		$m = Yii::app()->user->getFlash('REGISTRATION_FAIL_MESSAGE');
		if ( $m ) {
			echo $m;
		}
		?>
		<table>
		<tr>
			<td>Зарегистрироваться<strong>*</strong></td>
			
		</tr>
		<tr>
			
		</tr>
		<tr>
			<td>Город<strong>*</strong></td>
			<td class="full">
				<?php
				echo CHtml::textField('city', $_POST['city'], array('class' => 'cityAutoCompleteField'));
				echo $form->hiddenField($model, 'cityId');
				echo $form->error($model, 'cityId');
				?>
			</td>
		</tr>
		<tr>
			<td>Фамилия<strong>*</strong></td>
			<td class="full">
				<?php
				echo $form->textField($model, 'lastName');
				echo $form->error($model, 'lastName');
				?>
			</td>
		</tr>
		<tr>
			<td>Имя<strong>*</strong></td>
			<td class="full">
				<?php
				echo $form->textField($model, 'name');
				echo $form->error($model, 'name');
				?>
			</td>
		</tr>
		<tr>
			<td>Отчество</td>
			<td class="full">
				<?php
				echo $form->textField($model, 'patronymic');
				echo $form->error($model, 'patronymic');
				?>
			</td>
		</tr>
		<tr>
			<td>Сотовый телефон<strong>*</strong></td>
			<td>
				<?php
				echo '<span style="float:left;">+</span> ' . CHtml::textField('User[phone][]', $_REQUEST['User']['phone'][0] ? $_REQUEST['User']['phone'][0] : '7', array('class' => 'ph1', 'maxlength' => 3));
				echo CHtml::textField('User[phone][]', $_REQUEST['User']['phone'][1], array('class' => 'ph2', 'maxlength' => 4));
				echo CHtml::textField('User[phone][]', $_REQUEST['User']['phone'][2], array('class' => 'ph3', 'maxlength' => 7, 'style' => 'width:200px;'));
				echo $form->error($model, 'phone');
				?>
			</td>
		</tr>
		<tr>
			<td>ICQ</td>
			<td class="full">
				<?php
				echo $form->textField($model, 'icq');
				echo $form->error($model, 'icq');
				?>
			</td>
		</tr>
		<tr>
			<td>Skype</td>
			<td class="full">
				<?php
				echo $form->textField($model, 'skype');
				echo $form->error($model, 'skype');
				?>
			</td>
		</tr>
		<tr>
			<td>Укажите ваш E-mail<strong>*</strong></td>
			<td class="full">
				<?php
				echo $form->textField($model, 'email');
				echo $form->error($model, 'email');
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><p><strong>Это будет Ваш логин для входа на сайт!</strong></p></td>
		</tr>
		<tr>
			<td>Назначьте пароль<strong>*</strong></td>
			<td class="full">
				<?php

				$model->password = '';
				echo $form->passwordField($model, 'password');
				echo $form->error($model, 'password');
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><p>Все поля отмеченные (<strong>*</strong>) обязательны к заполнению</p></td>
		</tr>
		<tr>
			<td></td>
			<td class="go reg">
				<?php
				echo CHtml::submitButton('Зарегистрироваться');
				?>
			</td>
		</tr>
	</table>

	</div>
</div>
<?php
$this->endWidget();
