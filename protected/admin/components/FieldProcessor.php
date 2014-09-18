<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class FieldProcessor
{
	static function getActiveField($model, $item, $form)
	{

		switch ($item['type']) {
			case 'text' :
				{
				echo $form->textField($model, $item['attribute'], $item['htmlOptions']);
				}
				break;

            case 'password' :
				{
                    $model->$item['attribute'] = '';
				echo $form->passwordField($model, $item['attribute'], $item['htmlOptions']);
				}
				break;

			case 'textarea' :
				{
				echo $form->textArea($model, $item['attribute'], $item['htmlOptions']);
				}
				break;

			case 'autocomplete' :
				{
//					var_dump($item);
//					var_dump($model->attributes);
//					exit();
					$name = 'ac_'.get_class($model);

				Yii::app()->controller->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name' => $name,
						'value' => ($_POST[$name] ? $_POST[$name] : $item['value']),
						'source' => $item['source'],
						'options' => array(
							'minLength' => '2',
							'showAnim' => 'fold',
							'select' => 'js: function(event, ui) {
																		event.preventDefault();
																		event.stopPropagation();
																		this.value = ui.item.label;
																		$(this).next().val(ui.item.'.$item['attribute'].');
																		return false;
																}',
						),
						'htmlOptions' => array(
							'maxlength' => 100,
						),
					));
				echo $form->hiddenField($model, $item['attribute']);
				}
				break;

			case 'dropdown' :
				{
				echo $form->dropDownList($model, $item['attribute'],
					($item['data']['model'] ?
						CHtml::listData($item['data']['model'], $item['data']['valueField'], $item['data']['textField'])
						: $item['data']),
					$item['htmlOptions']);
				}
				break;

			case 'date' :
				{
				Yii::app()->controller->widget('zii.widgets.jui.CJuiDatePicker', array(
																					  'value' => $model->{$item['attribute']} ? date('d/m/Y', strtotime($model->{$item['attribute']})) : '',
																					  'name' => get_class($model) . '[' . $item['attribute'] . ']',
																					  'language' => 'ru',
																					  'htmlOptions' => CMap::mergeArray(
																						  array('size' => 10, 'maxlength' => 15, 'style' => 'height:20px;'),
																						  $item['htmlOptions'] ? $item['htmlOptions'] : array()),
																					  'options' => CMap::mergeArray(array(
																														 'showAnim' => 'fold',
																														 'changeMonth' => true,
																														 'changeYear' => true,
																														 'yearRange' => '1980:' . (date('Y')+10),
																														 'dateFormat' => 'dd/mm/yy'
																													), $item['options'] ? $item['options'] : array()),
																				 ));
				}
				break;

			case 'textEditor' :
				{

				Yii::app()->controller->widget('application.extensions.ckeditor.CKEditor', array(
																								'model' => $model,
																								'attribute' => $item['attribute'],
																								'language' => 'ru',
																								'editorTemplate' => 'full',
																						   ));

				}
				break;
            case 'file':{
                echo $form->fileField($model,'image','');
            }
            break;

			default:
				echo $form->textField($model, $item['attribute'], $item['htmlOptions']);
		}
		//		exit();
	}
}
