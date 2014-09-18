<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class Mailer
{
	protected static $_username = 'pokemon4ik2008@gmail.com';
	protected static $_password = '_Artem2008';
	protected static $_port = '465';
	protected static $_host = 'smtp.gmail.com';

	public static function sendRegMail($user)
	{

		$mail = self::getMailer();

		$mail->setFrom(self::$_username, Yii::app()->name);
		$mail->Subject = "Подтверждение регистрации";

		$mail->ClearAddresses();
		$mail->addAddress($user['email']);

		$mail->Body .= "Перейдите по ссылке " . Yii::app()->request->hostInfo . Yii::app()->controller->createUrl('/site/confirmregistration?code=' . $user['confirmCode']);

		if ( !$mail->Send() ) {
			Yii::log($mail->ErrorInfo, CLogger::LEVEL_ERROR);
			mail($user['email'], $mail->Subject, $mail->Body);
			return false;
		} else {
			return true;
		}

	}

	public static function sendMail($user, $message, $title = '')
	{

		$mail = self::getMailer();

		$mail->setFrom(self::$_username, Yii::app()->name);
		$mail->Subject = $title ? $title :"Письмо от пользователя";

		$mail->ClearAddresses();
		$mail->addAddress($user['email']);

		$model = Yii::app()->user->getModel();

		$mail->Body .= "{$message}";

		if ( !$mail->Send() ) {
			Yii::log($mail->ErrorInfo, CLogger::LEVEL_ERROR);
			mail($user['email'], $mail->Subject, $mail->Body);
			return false;
		} else {
			return true;
		}

	}

	protected static function getMailer()
	{
		require_once(Yii::getPathOfAlias('ext') . '/phpmailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 1;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';

		$mail->Host = self::$_host;
		$mail->Port = self::$_port;
		$mail->Username = self::$_username;
		$mail->Password = self::$_password;

		return $mail;
	}


	public static function sendForgotMail($email)
	{

		$mail = self::getMailer();

		$mail->setFrom(self::$_username, Yii::app()->name);
		$mail->Subject = "Восстановление пароля ";

		$mail->ClearAddresses();
		$mail->addAddress($email);

		$user = User::model()->findByAttributes(array('email' => $email));

		$user->confirmCode = md5($email . time() . time());
		$user->save(false);

		$mail->Body .= "Перейдите по ссылке " . Yii::app()->request->hostInfo . Yii::app()->controller->createUrl('/site/restorecode?code=' . $user['confirmCode']);

		if ( !$mail->Send() ) {
			Yii::log($mail->ErrorInfo, CLogger::LEVEL_ERROR);
			mail($email, $mail->Subject, $mail->Body);
			return false;
		} else {
			return true;
		}

	}

}
