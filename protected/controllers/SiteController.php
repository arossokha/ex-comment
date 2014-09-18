<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		
		$this->render('index', array(
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if (isset($_POST['ContactForm'])) {
			$model->attributes = $_POST['ContactForm'];
			if ($model->validate()) {
				$headers = "From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
				Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact', array('model' => $model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));

	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 *
	 */
	public function actionRegistrationConfirm()
	{
		if ($_POST['confirmEmail'] == Yii::app()->user->getModel()->email) {
			Mailer::sendRegMail(Yii::app()->user->getModel());
			$sended = true;
		}

		if (Yii::app()->user->isGuest) {
			$this->redirect('/site/registration');
			$email = Yii::app()->user->getFlash("REGISTERED_EMAIL");
		}

		$this->render('registrationconfirm', array('sended' => $sended, 'email' => Yii::app()->user->name));
	}

	/**
	 *
	 */
	public function actionRegistrationEnd()
	{
		$email = Yii::app()->user->getFlash("REGISTERED_EMAIL");

		if (!$email) {
			$this->redirect('/site/registration');
		}

		$this->render('registrationend', array(
			'email' => $email, 'message' => '<p><span>Внимание!</span> Для подтверждения регистрации 
			Вам нужно зайти в свой почтовый ящик и пройти по ссылке в письме.</p>
						'));
	}

	/**
	 * Registration of user
	 */
	public function actionRegistration()
	{
		Yii::app()->clientScript->registerScriptFile('/js/registration.js', CClientScript::POS_HEAD);

		$model = new User();

		if ($data = Yii::app()->request->getParam('User')) {

			$model->setAttributes($data);
			if ($model->save()) {
				Yii::app()->user->setFlash("REGISTERED_EMAIL", $model->email);
				Mailer::sendRegMail($model);
				$this->redirect('/site/registrationend');
			} else {
				Yii::app()->user->setFlash("REGISTRATION_FAIL_MESSAGE", "Пользователь не зарегестрирован. Исправте ошибки на форме");
			}
		}

		$this->render('register', array('model' => $model));
	}

	/**
	 * Registration of user
	 */
	public function actionConfirmRegistration($code)
	{
		$user = User::model()->find('confirmCode = :cC AND confirmed = 0', array(':cC' => $code));
		if ($user) {
			if ($user->confirmRegistration()) {
				$message = "Регистрация подтверждена";
			}
		} else {
			$message = "Невалидный код подтверждения";
		}

		$this->render('activation',
			array(
				'message' => $message
			));
	}


	public function actionUnreg()
	{
		$this->render('unreg');
	}

	/**
	 * Show pages by name
	 * @param $pageName string page name
	 */
	public function actionPage($pageName)
	{
		Yii::import('application.admin.models.Settings');
		$s = new Settings;

		if (isset($s->{$pageName})) {
			$this->render('page', array('page' => $s->{$pageName}));
			Yii::app()->end();
		}

		$page = Page::model()->find('path = :p ', array(':p' => $pageName));
		if ($page) {
			$this->render('page', array('page' => $page->text));
		} else {
			throw new CHttpException(404, Yii::t('app', 'Страница не найдена'));
		}
	}

	public function actionCity()
	{
		$term = Yii::app()->getRequest()->getParam('term');

		if (Yii::app()->request->isAjaxRequest && $term) {
			$criteria = new CDbCriteria;
			$term = Yii::app()->db->quoteValue($term.'%');
			$criteria->addCondition("name LIKE {$term}");
			$criteria->limit = 10;
			$cities = City::model()->findAll($criteria);
			$result = array();
			foreach ($cities as $city) {
				$result[] = array('cityId' => $city['cityId'], 'label' => $city['name'] . ',' . Region::getNameById($city['regionId']) . ',' . Country::getNameById($city['countryId']));
			}
			echo CJSON::encode($result);
			Yii::app()->end();
		}
	}

	public function actionRegion()
	{
		$term = Yii::app()->getRequest()->getParam('term');

		if (Yii::app()->request->isAjaxRequest && $term) {
			$criteria = new CDbCriteria;

			$criteria->addSearchCondition('name', $term);
			$criteria->limit = 10;
			$regions = Region::model()->findAll($criteria);
			$result = array();
			foreach ($regions as $region) {
				$result[] = array('regionId' => $region['regionId'], 'label' => $region['name'] . ',' . Country::getNameById($region['countryId']));
			}
			echo CJSON::encode($result);
			Yii::app()->end();
		}
	}

	public function actionFeedback()
	{

		$model = new FeedbackForm();
		if ($_POST['FeedbackForm']) {
			$model->setAttributes($_POST['FeedbackForm']);
			if (!Yii::app()->user->isGuest) {
				$model->email = Yii::app()->user->getModel()->email;
				$model->name = Yii::app()->user->getModel()->getName();
			}

			if ($model->send()) {
				$this->render('page', array('page' => 'Ваше уведомление отправлено!'));
				Yii::app()->end();

			}
		}

		$this->render('feedback', array(
			'model' => $model
		));

	}

	public function actionForgot()
	{
		$sended = null;
		$model = new ForgotForm();
		if (isset($_POST['ForgotForm'])) {
			$model->setAttributes($_POST['ForgotForm']);
			if ($model->validate()) {
				Mailer::sendForgotMail($model->email);
				$sended = true;
			} else {
				$sended = false;
			}
		}

		$this->render('forgot', array(
			'sended' => $sended,
			'model' => $model
		));
	}

	public function actionRestorecode($code){
		$user = User::model()->find('confirmCode = :cC', array(':cC' => $code));
		if ($user) {
			if($_POST['password']) {
				if ($user->confirmRegistration()) {

				}
			}
		} else {
			$message = "Невалидный код подтверждения";
		}

	}

}