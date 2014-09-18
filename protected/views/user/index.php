<?php
Yii::app()->clientScript->registerScript('search', "
$('form#user-form select').live('change',function(){
$.fn.yiiListView.update('user-view', {
	data: $(this).parents('form').serialize()
});
return false;
});
$('form#user-form input').live('keyup',function(){
$.fn.yiiListView.update('user-view', {
	data: $(this).parents('form').serialize()
});
return false;
});
");
?>

<h1>Фильтр<sup><a href="#">?</a></sup></h1>
<div id="filter">
	<?php $form = $this->beginWidget('CActiveForm', array(
														 'id' => 'user-form',
														 'action' => Yii::app()->createUrl($this->route),
														 'method' => 'get',
													)); ?>
	<div>
		<table>
			<tr>
				<td>Выбор по местонахождению</td>
				<td class="size1">
					<?php
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
																		   'name' => 'dd',
																		   'value' => $_POST['dd'],
																		   'source' => Yii::app()->createUrl('site/city'),
																		   'options' => array(
																			   'minLength' => '2',
																			   'showAnim' => 'fold',
																			   'select' => 'js: function(event, ui) {
																				event.preventDefault();
																				event.stopPropagation();
																				this.value = ui.item.label;
																				$(this).next().val(ui.item.cityId);
																				$.fn.yiiListView.update("user-view", {
																					data: $(this).parents("form").serialize()
																				});
																				return false;
																				}',
																		   ),
																		   'htmlOptions' => array(
																			   'maxlength' => 100,
																		   ),
																	  ));
					echo $form->hiddenField($model, 'cityId');
					?>
				</td>
			</tr>
			<tr>
				<td>Выбор по алфавиту</td>
				<td class="size1">
					<?php
					echo $form->dropDownList($model, 'orderBy', array('asc' => 'По алфавиту', 'desc' => "В обратном порядке"),
						array('empty' => 'Выберите порядок', 'class' => 'custom', 'style' => 'width:100px;'));
					?>
				</td>
			</tr>
			<tr>
				<td>Выбор по деятельности</td>
				<td class="size1">
					<?php
					echo $form->dropDownList($model, 'scopeOfActivityId',
						CHtml::listData(ScopeOfActivity::model()->findAll(array('condition' => 'type = ' . ScopeOfActivity::JURIDICAL_TYPE)), 'scopeOfActivityId', 'name'),
						array('class' => 'custom', 'empty' => 'Выберите сферу деятельности'));
					?>
				</td>
			</tr>
		</table>
	</div>
	<?php $this->endWidget(); ?>
</div>
<h1>Все Компании</h1>
<div id="table" class="four2 head">
	<table>
		<tr>
			<th>Название</th>
			<th>Страна - город - область</th>
			<th>Тип услуги</th>
			<th>Описание деятельности</th>
		</tr>
	</table>
</div>
<?php $this->widget('application.components.widgets.ListView', array(
																	'dataProvider' => $model->search(),
																	'id' => 'user-view',
																	'itemView' => '_view',
															   )); ?>
