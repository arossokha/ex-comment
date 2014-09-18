<?php
/**
 * Admin controller
 */

class AdminController extends Controller
{
	/**
	 * layout name
	 * @var string
	 */
	public $layout = '//layouts/admin';
	/**
	 * Admin title path
	 * @var string
	 */
	public $adminTitlePath = '/images/admin/title.png';
	/**
	 * Admin logo path
	 * @var string
	 */
	public $adminLogoPath = '/images/admin/logo.png';
	/**
	 * Admin logo url
	 * @var string
	 */
	public $adminLogoUrl = '/';
	/**
	 * show / hide navigation panel in admin layout
	 * @var bool
	 */
	public $showNavigationPanel = true;

	/**
	 * init admin controller
	 */
	public function init()
	{

		return parent::init();
	}

	public function filters()
	{

		return array(
			'accessControl'
		);
	}

	public function accessRules()
	{

		return array(
			array(
				'allow',
				'actions' => array(
					'error',
					'login',
					'logout',
					'remember',
					'cache'
				),
				'users' => array(
					'*'
				),
			),
			array(
				'allow',
				'actions' => array(
					'index',
					'show'
				),
				'users' => array(
					'@'
				),
			),
			array(
				'deny',
				'users' => array(
					'*'
				),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This action uses to show widgets by name
	 * @param $widget widget name from $panelSettings
	 */
	public function actionShow($widget, $action = '', $id = '')
	{
		// var_dump($_REQUEST);
		// exit();
		$data = AdminWidget::getWidgetDataByPath($widget);

		if ( !$data ) {
			throw new CHttpException(404, 'Page not found');
		}

		if ( !$action ) {
			$this->render('show', array(
									   'widgetClass' => ucfirst($data['class']),
									   'data' => $data
								  ));
		} else {
			$widgetClass = AdminWidget::getWidgetNameByAction($action);
			// var_dump($wi)
			if ( $widgetClass ) {
				$this->render('show', array(
										   'widgetClass' => ucfirst($widgetClass),
										   'data' => $data
									  ));
			} else {
				throw new CHttpException(404, Yii::t('app', 'Page not found'));
			}
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->layout = '//layouts/login';
		$model = new LoginForm;

		if ( isset($_POST['ajax']) && $_POST['ajax'] === 'login-form' ) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if ( isset($_POST['LoginForm']) ) {
			$model->attributes = $_POST['LoginForm'];

			if ( $model->validate() && $model->login() ) {

				$this->redirect('/admin');
			}
		}

		$this->render('login', array(
									'model' => $model
							   ));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('/admin');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = '//layouts/error';

		if ( $error = Yii::app()->errorHandler->error ) {

			if ( Yii::app()->request->isAjaxRequest ) echo $error['message'];
			else $this->render('error', $error);
		}
	}

	/**
	 * Action uses for restore password
	 * for restore password used need to enter his(her) email address
	 * if email address exists in db show message about successful send of notification
	 * and send to email address to entered notification with change password link
	 */
	public function actionRemember()
	{
		$this->layout = '//layouts/login';
		/**
		 * @todo : add correct logic here create RememberFormClass
		 */
		$this->render('remember');
	}

	/**
	 * This action uses to remove all server cache
	 */
	public function actionCache()
	{
		Yii::app()->cache->flushValues();
		$this->redirect(Yii::app()->request->returnUrl ? Yii::app()->request->returnUrl : '/admin');
	}

	/**
	 * @deprecated
	 * register user for admin
	 * DO NOT USE this method is not working
	 */
	public function actionRegister()
	{

		$user = new AdminUser();
		if ( $user->validate() ) {
			/**
			 * generate user password
			 */
			/**
			 * @todo: not good method for save password need REFACTORING
			 */
			// $pass = Security::createPassword($user);
			// $password = Security::cryptPassword($pass,Config::get('auth.salt'));
			// $user->password = $password;
			$pass = $user->password;
			$user->password = Security::cryptPassword($user->password, Config::get('auth.salt'));
			$user->save(false);
		}
	}
}
