<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'me', 'edit', 'orders'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'users' => array('admin'),
			),
			array(
				'deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render($model->role == User::ROLE_PHYSICAL_FACE ? 'viewPerson' : 'viewCompany',
			array(
				 'model' => $model,
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if ( isset($_POST['User']) ) {
			$model->attributes = $_POST['User'];
			if ( $model->save() )
				$this->redirect(array('view', 'id' => $model->userId));
		}

		$this->render('create', array(
									 'model' => $model,
								));
	}

	public function actionMe()
	{
		$model = $this->loadModel(Yii::app()->user->id);

		$this->render($model->role == User::ROLE_PHYSICAL_FACE ? 'viewPerson' : 'viewCompany',
			array(
				 'model' => $model,
				 'edit' => true
			));
	}

	public function actionEdit()
	{

		$model = $this->loadModel(Yii::app()->user->id);

		if ( isset($_POST['User']) ) {
			$model->attributes = $_POST['User'];
			if ( $model->save() ) {
				$this->redirect('/user/me');
			}
		}

		$this->render($model->role == User::ROLE_PHYSICAL_FACE ? 'editPerson' : 'editCompany', array(
																									'model' => $model
																							   ));

	}

	public function actionSend($id)
	{
		throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		$model = $this->loadModel($id);
		Mailer::sendRegMail($model);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if ( Yii::app()->request->isPostRequest ) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if ( !isset($_GET['ajax']) )
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new User('search');
		$model->unsetAttributes(); // clear any default values
		$model->role = User::ROLE_JURIDICAL_FACE;
		if ( isset($_GET['User']) )
			$model->attributes = $_GET['User'];

		$this->render('index', array(
									'model' => $model,
							   ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		if ( $model === null )
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if ( isset($_POST['ajax']) && $_POST['ajax'] === 'user-form' ) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionOrders()
	{

//		$this->render('index', array(
//			'cargoes' => $cargoes,
//			'transports' => $transports,
//			'tenders' => $tenders,
//			'model' => $model,
//		));


		Cargo::disableDefaultScope();
		$cargo = new CActiveDataProvider('Cargo',array(
			'criteria' => array(
				'condition' => 'cargo.active = 1 and userId = :id',
				'params' => array(
					':id' => Yii::app()->user->getModel()->primaryKey
				)
			)
		));


		Transport::disableDefaultScope();
		$transport = new CActiveDataProvider('Transport',array(
			'criteria' => array(
				'condition' => 'transport.active = 1 and userId = :id',
				'params' => array(
					':id' => Yii::app()->user->getModel()->primaryKey
				)
			)
		));

		$tender = new CActiveDataProvider('Tender',array(
			'criteria' => array(
				'condition' => 'tender.active = 1 and userId = :id',
				'params' => array(
					':id' => Yii::app()->user->getModel()->primaryKey
				)
			)
		));

		$this->render('orders', array(
									'transports' => $transport
									, 'tenders' => $tender
									, 'cargoes' => $cargo
								));
	}

}
