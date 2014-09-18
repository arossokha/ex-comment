<?php
/**
 * 
 */
class FavoriteController extends Controller {
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters() {
		
		return array(
			'accessControl', // perform access control for CRUD operations
			
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		
		return array(
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array(
					'index',
					'create',
					'delete'
				) ,
				'users' => array(
					'@'
				) ,
			) ,
			array(
				'deny', // deny all users
				'users' => array(
					'*'
				) ,
			) ,
		);
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new Favorite;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset($_POST['Favorite'])) {
			$model->attributes = $_POST['Favorite'];
			
			if ($model->save()) {
				echo CJSON::encode(array(
					'status' => true
				));
			} else {
				echo CJSON::encode(array(
					'status' => false
				));
			}
			Yii::app()->end();
		}
		throw new CHttpException(400, 'Такой страницы нет');
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$m = $this->loadModel($id);
			
			if ($m && $m->userId == Yii::app()->user->id) {
				if($m->delete()){

				} else {
					throw new CHttpException(400, 'У Вас не достаточно прав что бы сделать это!');
				}
			} else {
				throw new CHttpException(400, 'У Вас не достаточно прав что бы сделать это!');
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			
			// if (!isset($_GET['ajax'])) $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
			// 	'admin'
			// ));
		} else throw new CHttpException(400, 'Такой страницы нет');
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$model = new Favorite('search');
		$model->unsetAttributes(); // clear any default values
		
		if (isset($_REQUEST['Favorite'])) {
			$model->attributes = $_GET['Favorite'];
		}
		//		$favorites = Favorite::model()->findAll('modelName LIKE :t ',array(':t' => '%'.$model->modelName.'%'));
		$favorites = Favorite::model()->findAllBySql('
		select f.* FROM Favorite `f`
		LEFT JOIN Tender ON tenderId = modelId AND modelName=\'Tender\'
		LEFT JOIN Transport ON transportId = modelId AND modelName=\'Transport\'
		LEFT JOIN Cargo ON cargoId = modelId AND modelName=\'Cargo\'
		LEFT JOIN User ON User.userId = modelId AND modelName=\'User\'
		where
		f.userId = :u AND
		modelName LIKE :t AND (
			NOT ISNULL( tenderId )
			OR NOT ISNULL( cargoId )
			OR NOT ISNULL( User.userId )
			OR NOT ISNULL( transportId )
		)', array(
			':t' => '%' . $model->modelName . '%',
			':u' => Yii::app()->user->id
		));
		$ids = array();
		
		foreach ($favorites as $it) {
			$ids[$it['modelName']][] = Yii::app()->db->quoteValue($it['modelId']);
		}
		
		/**
		 * Disable all defaults scopes 
		 */
		Cargo::disableDefaultScope();
		Transport::disableDefaultScope();
		Tender::disableDefaultScope();
		User::disableDefaultScope();


		$cargoes = new CActiveDataProvider('Cargo', array(
			'criteria' => array(
				'condition' => 'cargo.cargoId in (' . ($ids['Cargo'] ? implode(',', $ids['Cargo']) : 0) . ')'
			) ,
			'pagination' => false
		));
		$transports = new CActiveDataProvider('Transport', array(
			'criteria' => array(
				'condition' => 'transport.type = ' . Transport::TRANSPORT . ' AND  transport.transportId in (' . ($ids['Transport'] ? implode(',', $ids['Transport']) : 0) . ')'
			) ,
			'pagination' => false
		));
		$tenders = new CActiveDataProvider('Tender', array(
			'criteria' => array(
				'condition' => 'tender.tenderId in (' . ($ids['Tender'] ? implode(',', $ids['Tender']) : -1) . ')'
			) ,
			'pagination' => false
		));
		$users = new CActiveDataProvider('User', array(
			'criteria' => array(
				//					'scopes' => array('juridical'),
				'condition' => 'User.userId in (' . ($ids['User'] ? implode(',', $ids['User']) : -1) . ')'
			) ,
			'pagination' => false
		));
		$this->render('index', array(
			'cargoes' => $cargoes,
			'transports' => $transports,
			'tenders' => $tenders,
			'users' => $users,
			'model' => $model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = Favorite::model()->findByPk($id);
		
		if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
		
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'favorite-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
