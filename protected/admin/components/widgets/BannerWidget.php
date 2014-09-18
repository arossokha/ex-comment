<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artem
 * Date: 12/3/12
 * Time: 11:32 PM
 * To change this template use File | Settings | File Templates.
 */
class BannerWidget extends AdminWidget
{

	public $returnUrl;
	protected $modelName;

	public function init()
	{
		if ( $this->params['importPath'] ) {
			Yii::import($this->params['importPath']);
		}

		$this->modelName = !is_array($this->params['model']) ? $this->params['model'] : $this->params['model']['class'];

		$this->returnUrl = "/admin/" . $this->params['path'];


		return parent::init();
	}

	public function run()
	{
//
//		$model = Banner::model()->find(array(
//			'condition' => ' dateTo <= NOW() AND dateFrom >= NOW() ',
//			'order' => 'bannerId DESC'
//		));

		$model = Banner::model()->find(array(
			'condition' => " dateFrom >= '".date('Y-m-d')."' AND dateFrom <= '".date('Y-m-d')."'"
		));

		if(!$model) {
			$model = new $this->modelName();
		}

		if ( !in_array('CModel', class_parents($model)) ) {
			throw new CException('Not correct model class');
		}

		if(Yii::app()->request->isPostRequest && $_FILES['file']['name']) {
			$t = $_FILES['file']['type'];
			if($t != 'image/png' && $t != 'image/jpg' && $t != 'image/jpeg' && $t != 'image/gif') {
				echo CJSON::encode(array(
					'status' => 'ok',
					'msg' => "Error incorrect file format"
				));
				Yii::app()->end();
			}

			$newFileName = Yii::getPathOfAlias('webroot').'/public/'.time().'_'.$_FILES['file']['name'];
			$newFileUrl = '/public/'.time().'_'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],$newFileName);
			$s = getimagesize($newFileName);
			echo CJSON::encode(array(
				'status' => 'ok',
				'name' => $newFileUrl,
				'path' => $newFileName,
				'size' => $s[0].'x'.$s[1]
			));
			Yii::app()->end();
		}

		if(!empty($_REQUEST['Banner'])) {
			$model->setAttributes($_REQUEST['Banner']);
			$model->save();
		}

		if ( isset($_POST[$this->modelName]) ) {
			$model->attributes = $_POST[$this->modelName];
		}

		$modelColumns = array_keys($model->tableSchema->columns);
//
//		if ( $model->asa('AdminBehavior') ) {
//			$columns = $model->getColumnSettingsForAdminPanel();
//		} else {
//			$columns = array($model->tableSchema->primaryKey, $modelColumns[1]);
//		}

		$columns = array('bannerId','dateFrom','dateTo');

		//		var_dump($this->params);
		//		exit();

		$buttonColumn = array(
			'template' => '{delete}',
			'class' => 'CButtonColumn',
			'deleteButtonUrl' => '"/admin/".$this->grid->owner->params["path"]."/delete/".$data->primaryKey',
		);

		if(Yii::app()->request->isPostRequest) {
			echo $this->render('banner', array(
				'model' => $model,
				'columns' => $columns,
				'buttonColumn' => $buttonColumn,
			),true);

			Yii::app()->end();
		} else {
			$this->render('banner', array(
				'model' => $model,
				'columns' => $columns,
				'buttonColumn' => $buttonColumn,
			));
		}


	}
}
