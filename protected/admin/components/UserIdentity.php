<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * User model
	 * @var User
	 */
	protected $user;

	/**
	 * constructor
	 * @param string $username
	 * @param $password
	 */
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}


	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = AdminUser::model()->find(array(
											  'condition' => 'login = :l',
											  'params' => array(
												  ':l' => $this->username,
											  )
										 ));

		if ( !$user ) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			if ( $this->isPasswordValid($user) ) {
				$this->user = $user;
				$this->errorCode = self::ERROR_NONE;
			} else {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			}
		}

		//		$this->errorCode = self::ERROR_NONE;
		return !$this->errorCode;

	}

	/**
	 * Validate user password
	 * @param $user
	 * @return bool
	 */
	protected function isPasswordValid($user)
	{
		return $user->password == Security::cryptPassword($this->password, '');
	}

	/**
	 * return correct User model
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}
}