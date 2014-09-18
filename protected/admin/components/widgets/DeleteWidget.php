<?php
/**
 * Delete widget
 * remove model data
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class DeleteWidget extends AdminWidget
{
	protected $modelName;
	protected $returnUrl;
	protected $id;

	public function init()
	{
		$this->modelName = !is_array($this->params['model']) ? $this->params['model'] : $this->params['model']['class'];
		$this->id = Yii::app()->request->getParam('id', null);

		if ( $this->params['importPath'] ) {
			Yii::import($this->params['importPath']);
		}

		return parent::init();
	}

	public function run()
	{

		if ( $this->id ) {
			$model = ActiveRecord::model($this->modelName)->findByPk($this->id);
		} else {
			$model = new $this->modelName();
		}
		if ( !in_array('CModel', class_parents($model)) ) {
			throw new CException('Not correct model class');
		}

		if ( Yii::app()->request->isPostRequest ) {
			if ( $model->delete() ) {
				Yii::app()->user->setFlash("OPERATION_RESULT", "Удалено успешно");
			} else {
				Yii::app()->user->setFlash("OPERATION_RESULT", "Не сохранено");
			}
		} else {

		}
	}
}
