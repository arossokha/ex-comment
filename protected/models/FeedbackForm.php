<?php
/**
 * Feedback
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class FeedbackForm extends CFormModel
{
	public $email;
	public $name;
	public $title;
	public $message;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('name, email, message, title', 'required'),
				array('name, email', 'length', 'max' => 100),
				array('email', 'email'),
				array('message', 'safe'),
			);
	}

	public function attributeLabels(){
		return array(
			'message' => 'Сообщение',
			'title' => 'Тема',
			'name' => 'Имя'
		);
	}

	public function send() {
		Yii::import('application.admin.models.Settings');

		if($this->validate()) {
			$s = new Settings();
			$m = $this->message;

			if(!in_array($this->title,array( 'Сообщение об ошибке','Сообщение по рекламе',
										   'Сообщение о сотрудничестве','Другое'))){
				$this->title = 'Другое';
			}

			$m .= '<br> от пользователя '.$this->name.'('.$this->email.')';
			Mailer::sendMail(array('email' => $s->feedbackEmail),$m,$this->title);
			return true;
		}

		return false;
	}
}
