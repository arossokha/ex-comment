<?php

class ForgotForm extends CFormModel
{
	public $email;

	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'exist','className' => 'User','attributeName' => 'email','message' => 'Введённый Вами e-mail не числится в базе!')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'Email' => 'Email',
		);
	}

}
