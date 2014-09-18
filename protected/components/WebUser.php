<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class WebUser extends CWebUser
{
	protected $_model = null;

	public function getModel()
	{
		if ( !$this->_model ) {
			$this->_model = User::model()->findByPk($this->getState('id'));
		}

		if ( !$this->_model ) {
			Yii::app()->user->logout();
			Yii::app()->controller->redirect(Yii::app()->homeUrl);
		}

		return $this->_model;
	}
}
