<?php
/**
 * Model Manager widget
 * use model for save data
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class ModelManagerLimiterWidget extends AdminWidget
{
	protected $modelName;

	public function init()
	{
		//		var_dump($this->params);
		$this->modelName = !is_array($this->params['model']) ? $this->params['model'] : $this->params['model']['class'];

		if ( $this->params['importPath'] ) {
			Yii::import($this->params['importPath']);
		}

		return parent::init();
	}

	public function run()
	{

		$model = new $this->modelName();
		if ( !in_array('CModel', class_parents($model)) ) {
			throw new CException('Not correct model class');
		}

		if ( isset($_POST[$this->modelName]) ) {
			$model->attributes = $_POST[$this->modelName];
		}

		$modelColumns = array_keys($model->tableSchema->columns);

		if ( $model->asa('AdminBehavior') ) {
			$columns = $model->getColumnSettingsForAdminPanel();
		} else {
			$columns = array($model->tableSchema->primaryKey, $modelColumns[1]);
		}

		//		var_dump($this->params);
		//		exit();

		$buttonColumn = array(
			'template' => '{update} {delete}',
			'class' => 'CButtonColumn',
			'deleteButtonUrl' => '"/admin/".$this->grid->owner->params["path"]."/delete/".$data->primaryKey',
			'updateButtonUrl' => '"/admin/".$this->grid->owner->params["path"]."/update/".$data->primaryKey'

		);
		//		$buttonColumn = array();

		$this->render('modelmangerlimiter', array(
										  'model' => $model,
										  'columns' => $columns,
										  'buttonColumn' => $buttonColumn,
									 ));
	}
}
