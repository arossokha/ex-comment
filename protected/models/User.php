<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $userId
 * @property string $name
 * @property string $lastName
 * @property string $patronymic
 * @property string $phone
 * @property string $workPhone
 * @property string $fax
 * @property string $icq
 * @property string $url
 * @property string $skype
 * @property string $email
 * @property string $login
 * @property string $password
 * @property string $salt
 * @property integer $role
 * @property integer $cityId
 * @property string $address
 * @property string $info
 * @property integer $confirmed
 * @property string $confirmCode
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class User extends ActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, name, cityId, lastName, phone, email', 'required', 'on' => 'physical'),
			array('password, workPhone, address, name, cityId, lastName, phone, email', 'required', 'on' => 'juridical'),

			array('role, cityId, active', 'numerical', 'integerOnly' => true),
			array('name, lastName, patronymic, icq, login', 'length', 'max' => 20),
			array('phone, workPhone, fax', 'length', 'max' => 30),

			array('skype, email', 'length', 'max' => 50),
			array('url', 'length', 'max' => 100),
			array('info', 'length', 'max' => 200),
			array('url', 'url'),
			array('email', 'email'),
			array('email', 'unique'),
			array('phone, workPhone, fax', 'match', 'pattern' => '/^(\s|\d)+$/', 'message' => 'В номере должны быть указаны только цифры'),
			//			array('password', 'length', 'max'=>40),
			//			array('salt', 'length', 'max'=>100),
			array('address', 'length', 'max' => 250),
			array('info, confirmCode, confirmed, password', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('orderBy, userId, name, lastName, patronymic, phone, workPhone, fax, icq, skype, email, login, password, salt, role, cityId, address, info, active', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(

		);
	}


	public function scopes()
	{
		return array(

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => 'Пользователь',
			'name' => 'Имя',
			'lastName' => 'Фамилия',
			'patronymic' => 'Отчество',
			'phone' => 'Телефон',
			'workPhone' => 'Рабочий телефон',
			'fax' => 'Факс',
			'icq' => 'Icq',
			'url' => 'Сайт',
			'skype' => 'Skype',
			'email' => 'Email',
			'login' => 'Логин',
			'password' => 'Пароль',
			'salt' => 'Хэш',
			'role' => 'Роль',
			'cityId' => 'Город',
			'address' => 'Адрес',
			'info' => 'Описание',
			'active' => 'Active',
			'updated_timestamp' => 'Updated Timestamp',
			'created_timestamp' => 'Created Timestamp',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('User.userId', $this->userId);
		$criteria->compare('User.name', $this->name, true);
		$criteria->compare('User.lastName', $this->lastName, true);
		$criteria->compare('User.patronymic', $this->patronymic, true);
		$criteria->compare('User.phone', $this->phone, true);
		$criteria->compare('User.workPhone', $this->workPhone, true);
		$criteria->compare('User.fax', $this->fax, true);
		$criteria->compare('User.icq', $this->icq, true);
		$criteria->compare('User.skype', $this->skype, true);
		$criteria->compare('User.email', $this->email, true);
		$criteria->compare('User.login', $this->login, true);
		$criteria->compare('User.password', $this->password, true);
		$criteria->compare('User.salt', $this->salt, true);
		$criteria->compare('User.role', $this->role);
		$criteria->compare('User.cityId', $this->cityId);
		$criteria->compare('User.address', $this->address, true);
		$criteria->compare('User.info', $this->info, true);
		$criteria->compare('User.active', $this->active);

		return new ActiveDataProvider($this, array(
												  'criteria' => $criteria,
											 ));
	}

	public function beforeValidate()
	{
		foreach (array('phone', 'fax', 'workPhone') as $attr) {
			if ( is_array($this->$attr) ) {
				foreach ($this->$attr as $k => &$it) {
					$it = trim($it);
					if ( $k == 3 ) {
						$it = '(' . $it . ')';
					}

				}
				$this->$attr = implode(' ', $this->$attr);
				if ( strlen($this->$attr) < 5 ) {
					$this->$attr = '';
				}
			}
		}

		if ( $this->url == 'http://' ) {
			$this->url = '';
		}

		if ( !$this->confirmCode ) {
			$this->confirmCode = md5($this->email . time() . time());
		}

		if ( $this->password ) {
			$this->password = Security::cryptPassword($this->password, '1');
		}

		if ( $this->isNewRecord ) {
			$this->created_timestamp = date('Y-m-d H:i:s');
		}

		return parent::beforeValidate();
	}

	public function confirmRegistration()
	{
		$this->confirmed = 1;
		$this->confirmCode = '';
		$this->save(false);
		return true;
	}

	public function getName()
	{
		if ( $this->role == self::ROLE_JURIDICAL_FACE ) {
			return $this->patternsOfOwnership->name . ' "' . $this . '"';
		}
		return $this->lastName . ' ' . $this->name . ' ' . $this->patronymic;
	}

	public function getFormatedPhone()
	{
		$p = $this->phone;
		if(!$p || strlen($p) < 5){
			return '';
		}
		$t = explode(' ',$p);
		$p = $t[0].' ('.$t[1].') '.$t[2].($t[3] ? 'доб. '.$t[3] : '');
		return '+' . $p;
	}

	public function getFormatedWorkPhone()
	{
		$p = $this->workPhone;
		if(!$p || strlen($p) < 5){
			return '';
		}
		$t = explode(' ',$p);
		$p = $t[0].' ('.$t[1].') '.$t[2].($t[3] ? ' доб. '.$t[3] : '');
		return '+' . $p;
	}

	public function getFormatedFax()
	{
		$p = $this->fax;
		if(!$p || strlen($p) < 5){
			return '';
		}
		$t = explode(' ',$p);
		$p = $t[0].' ('.$t[1].') '.$t[2].($t[3] ? ' доб. '.$t[3] : '');
		return '+' . $p;
	}

	public function defaultScope()
	{
		return array(
			'alias' => 'User',
			'order' => '1 desc'
		);
	}

}