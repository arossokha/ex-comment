<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
?>
<h1>Обновление профиля</h1>
<div id="filter">
<?php $form = $this->beginWidget('CActiveForm', array(
													 'id' => 'user-form',
													 'enableAjaxValidation' => false,
												));
?>
<div>
<table>
<tr>
	<td>Сфера деятельности<strong>*</strong></td>
	<td>
		<?php
		echo $form->dropDownList($model, 'scopeOfActivityId', CHtml::listData(ScopeOfActivity::model()->findAll(array('condition' => 'type = ' . ScopeOfActivity::JURIDICAL_TYPE)), 'scopeOfActivityId', 'name'), array('class' => 'custom', 'empty' => 'Выберите сферу деятельности'));
		echo $form->error($model, 'scopeOfActivityId');
		?>
	</td>
</tr>
<tr>
	<td>Название компании<strong>*</strong></td>
	<td class="full">
		<?php
		echo $form->textField($model, 'companyName');
		echo $form->error($model, 'companyName');
		?>
	</td>
</tr>
<tr>
	<td>Форма собственности<strong>*</strong></td>
	<td>
		<?php
		echo $form->dropDownList($model, 'patternsOfOwnershipId', CHtml::listData(PatternsOfOwnership::model()->findAll(), 'patternsOfOwnershipId', 'name'), array('class' => 'custom', 'empty' => 'Выберите форму собственности'));
		echo $form->error($model, 'patternsOfOwnershipId');
		?>
	</td>
</tr>
<tr>
	<td>ИНН<strong>*</strong></td>
	<td class="full">
		<?php
		echo $form->textField($model, 'tin');
		echo $form->error($model, 'tin');
		?>
	</td>
</tr>
<tr>
	<td>Город<strong>*</strong></td>
	<td class="full">
		<?php
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
															   'name' => 'cc',
															   'value' => $_POST['cc'],
															   'source' => Yii::app()->createUrl('site/city'),
															   'options' => array(
																   'minLength' => '2',
																   'showAnim' => 'fold',
																   'select' => 'js: function(event, ui) {
																		event.preventDefault();
																		event.stopPropagation();
																		this.value = ui.item.label;
																		$(this).next().val(ui.item.cityId);
																		return false;
																	}',
															   ),
															   'htmlOptions' => array(
																   'maxlength' => 100,
															   ),
														  ));
		echo $form->hiddenField($model, 'cityId');
		echo $form->error($model, 'cityId');
		?>
	</td>
</tr>
<tr>
	<td>Адрес<strong>*</strong></td>
	<td>
		<?php
		echo $form->textArea($model, 'address', array('cols' => '100', 'rows' => '2'));
		echo $form->error($model, 'address');
		?>
	</td>
</tr>
<tr>
	<td>Описание</td>
	<td>
		<?php
		echo $form->textArea($model, 'info', array('cols' => '100', 'rows' => '2', 'class' => 'calculateSymbols'));
		echo $form->error($model, 'info');
		?>
	</td>
</tr>
<tr>
	<td></td>
	<td><p>Опишите деятельность вашей компании не более <span
		class="countSymbols"><?php echo '' . (strlen($model->info) >= 200 ? 0 : 200 - strlen($model->info)); ?></span>
		символов</p></td>
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

		if(!$_REQUEST['User']['phone']){
			if($model->phone){
				$p = explode(' ',$model->phone);
				$_REQUEST['User']['phone'] = $p;
			}
		}

		echo '<span style="float:left;">+</span> ' . CHtml::textField('User[phone][]', $_REQUEST['User']['phone'][0] ? $_REQUEST['User']['phone'][0] : '7', array('class' => 'ph1', 'maxlength' => 3));
		echo CHtml::textField('User[phone][]', $_REQUEST['User']['phone'][1], array('class' => 'ph2', 'maxlength' => 4));
		echo CHtml::textField('User[phone][]', $_REQUEST['User']['phone'][2], array('class' => 'ph3', 'maxlength' => 7, 'style' => 'width:200px;'));
		echo $form->error($model, 'phone');
		?>
	</td>
</tr>
<tr>
	<td>Рабочий<strong>*</strong></td>
	<td>
		<?php
		if(!$_REQUEST['User']['workPhone']){
			if($model->workPhone){
				$p = explode(' ',$model->workPhone);
				$_REQUEST['User']['workPhone'] = $p;
			}
		}
		echo '<span style="float:left;">+</span> ' . CHtml::textField('User[workPhone][]', $_REQUEST['User']['workPhone'][0] ? $_REQUEST['User']['workPhone'][0] : '7', array('class' => 'ph1', 'maxlength' => 3));
		echo CHtml::textField('User[workPhone][]', $_REQUEST['User']['workPhone'][1], array('class' => 'ph2', 'maxlength' => 4));
		echo CHtml::textField('User[workPhone][]', $_REQUEST['User']['workPhone'][2], array('class' => 'ph3', 'maxlength' => 7));
		echo '<span style="float:left;margin-right: 10px;">доб.</span> ';
		echo CHtml::textField('User[workPhone][]', $_REQUEST['User']['workPhone'][3], array('class' => 'ph3', 'maxlength' => 6));
		echo $form->error($model, 'workPhone');
		?>
	</td>
</tr>
<tr>
	<td>Факс</td>
	<td>
		<?php
		if(!$_REQUEST['User']['fax']){
			if($model->fax){
				$p = explode(' ',$model->fax);
				$_REQUEST['User']['fax'] = $p;
			}
		}
		echo '<span style="float:left;">+</span> ' . CHtml::textField('User[fax][]', $_REQUEST['User']['fax'][0] ? $_REQUEST['User']['fax'][0] : '7', array('class' => 'ph1', 'maxlength' => 3));
		echo CHtml::textField('User[fax][]', $_REQUEST['User']['fax'][1], array('class' => 'ph2', 'maxlength' => 4));
		echo CHtml::textField('User[fax][]', $_REQUEST['User']['fax'][2], array('class' => 'ph3', 'maxlength' => 7));
		echo '<span style="float:left;margin-right: 10px;">доб.</span> ';
		echo CHtml::textField('User[fax][]', $_REQUEST['User']['fax'][3], array('class' => 'ph3', 'maxlength' => 6));
		echo $form->error($model, 'fax');
		?>
	</td>
</tr>
<tr>
	<td>Сайт</td>
	<td class="full">
		<?php
		echo $form->textField($model, 'url');
		echo $form->error($model, 'url');
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
		echo CHtml::submitButton('Сохранить');
		?>
	</td>
</tr>
</table>
</div>
<?php
$this->endWidget();
?>
</div>