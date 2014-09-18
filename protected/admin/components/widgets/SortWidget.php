<?php
/**
 * sort mechanism for models
 */
class SortWidget extends AdminWidget
{
	public function run()
	{

		Yii::import('application.models.*');

		$path = Yii::app()->request->getParam('path');
		$id = Yii::app()->request->getParam('id');

		$widget = Yii::app()->request->getParam('widget');
		$data = AdminWidget::getWidgetDataByPath($widget);
		$modelName = $data['model'];
		$tableName = ActiveRecord::model($modelName)->tableName();

		$d = Yii::app()->db->createCommand('select MAX(sort),MIN(sort) FROM '.$tableName. ' where active = 1')->queryRow(false);
		$max = intval($d[0]);
		$min = intval($d[1]);

		$pk = ActiveRecord::model($modelName)->tableSchema->primaryKey;

		$model = ActiveRecord::model($modelName)->findByPk($id);

		if (
			($model->sort != $max && $path == 'down')
			||
			($model->sort != $min && $path == 'up')
		) {
			if ($path == 'down') {
				$s = $model->sort + 1;
				$c = Yii::app()->db->createCommand("update {$tableName} set sort = sort-1 where sort = {$s}")->execute();
				$r = Yii::app()->db->createCommand("update {$tableName} set sort = sort+1 where {$pk} = {$id}")->execute();

			} else {
				$s = $model->sort - 1;
				$c = Yii::app()->db->createCommand("update {$tableName} set sort = sort+1 where sort = {$s}")->execute();
				$r = Yii::app()->db->createCommand("update {$tableName} set sort = sort-1 where {$pk} = {$id}")->execute();
			}

		}

	}

}
