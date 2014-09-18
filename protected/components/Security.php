<?php
/**
 * Security class contains all crypt decript function
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class Security
{
	protected static $key = '9605959095f1e07ba7628a197088bd70';

	private function __construct() { }

	private function __clone() { }

	/**
	 * Encrypt function
	 * @static
	 * @param $data
	 * @param $key
	 * @return string
	 */
	public static function encrypt($data, $key = '')
	{
		if ( empty($key) ) {
			$key = self::$key;
		}
		return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $data, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
		//        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $data, MCRYPT_MODE_CBC, md5($key)));
	}

	/**
	 * decrypt function
	 * @static
	 * @param $data
	 * @return string
	 */
	public static function decrypt($data, $key = '')
	{
		if ( empty($key) ) {
			$key = self::$key;
		}
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($data), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		//        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($data), MCRYPT_MODE_CBC, md5($key)), "\0");
	}

	/**
	 * salt generator
	 * @static
	 * @param $data
	 * @return string
	 */
	public static function generateSalt($data, $key = '')
	{
		if ( empty($key) ) {
			$key = self::$key;
		}
		return hash('crc32b', $key . $data, false);
	}

	/**
	 * user password creation
	 * @static
	 * @param $user
	 * @return string
	 */
	public static function createPassword($user)
	{
		return hash('crc32b', $user->email ? $user->email : $user->phone, false);
	}

	/**
	 * user password encryption
	 * @static
	 * @param $data
	 * @param $hash
	 * @param int $len
	 * @return string
	 */
	public static function cryptPassword($data, $hash)
	{
		return md5($data . $hash);
	}

	/**
	 * generate session token
	 * @static
	 * @return string token
	 */
	public static function generateToken()
	{
		/**
		 * @todo: normal generate access token
		 */
		return 'acc_' . md5(time() . Yii::app()->user->id . Config::get('auth.tokenHash'));
	}

}
