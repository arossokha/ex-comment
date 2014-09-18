<?php
/**
 * Model widget
 * use model for save data
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class ModelWidget extends AdminWidget
{
	protected $modelName;
	protected $returnUrl;
	protected $id;

	public function setReturnUrl($returnUrl)
	{
		$this->returnUrl = $returnUrl;
	}

	public function init()
	{
		$this->modelName = !is_array($this->params['model']) ? $this->params['model'] : $this->params['model']['class'];
		$this->id = Yii::app()->request->getParam('id', null);

		if ( $this->params['importPath'] ) {
			Yii::import($this->params['importPath']);
		}

		$this->returnUrl = $this->params['returnUrl'];
		if ( !$this->params['returnUrl'] ) {
			$this->returnUrl = "/admin/" . $this->params['path'];
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

		if ( isset($_POST[$this->modelName]) ) {
			$model->attributes = $_POST[$this->modelName];

			if ( $model->save() ) {
				Yii::app()->user->setFlash("OPERATION_RESULT", "Сохранено успешно");
				$this->getController()->redirect($this->returnUrl ? $this->returnUrl : Yii::app()->user->getReturnUrl($this->returnUrl ? $this->returnUrl : '/admin'));
			} else {
				Yii::app()->user->setFlash("OPERATION_RESULT", "Не сохранено");
			}
		}

		$this->render('model', array(
									'model' => $model,
									'buttonType' => "save",
									'attributes' => $model->getFieldSettingsForAdminPanel(),
							   ));
	}
}
