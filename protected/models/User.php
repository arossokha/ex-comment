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
 * @property integer $scopeOfActivityId
 * @property integer $cityId
 * @property integer $patternsOfOwnershipId
 * @property string $address
 * @property string $companyName
 * @property string $info
 * @property string $tin
 * @property integer $confirmed
 * @property string $confirmCode
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class User extends ActiveRecord
{

	/**
	 * role types
	 */
	const ROLE_PHYSICAL_FACE = 0;
	const ROLE_JURIDICAL_FACE = 1;

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
			array('password, name, scopeOfActivityId, cityId, lastName, phone, email', 'required', 'on' => 'physical'),
			array('password, patternsOfOwnershipId, workPhone, address, companyName, tin, name, scopeOfActivityId, cityId, lastName, phone, email', 'required', 'on' => 'juridical'),

			array('role, scopeOfActivityId, cityId, patternsOfOwnershipId, active', 'numerical', 'integerOnly' => true),
			array('name, lastName, patronymic, icq, login, tin', 'length', 'max' => 20),
			array('phone, workPhone, fax', 'length', 'max' => 30),

			array('skype, email', 'length', 'max' => 50),
			array('url', 'length', 'max' => 100),
			array('info', 'length', 'max' => 200),
			array('url', 'url'),
			array('email', 'email'),
			array('email', 'unique'),
			array('phone, workPhone, fax', 'match', 'pattern' => '/^(\s|\d)+$/', 'message' => 'В номере должны быть указаны только цифры'),
			array('tin', 'unique'),
			//			array('password', 'length', 'max'=>40),
			//			array('salt', 'length', 'max'=>100),
			array('address, companyName', 'length', 'max' => 250),
			array('info, confirmCode, confirmed, password', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('orderBy, userId, name, lastName, patronymic, phone, workPhone, fax, icq, skype, email, login, password, salt, role, scopeOfActivityId, cityId, patternsOfOwnershipId, address, companyName, info, tin, active', 'safe', 'on' => 'search'),
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
			'city' => array(self::BELONGS_TO, 'City', 'cityId'),
			'scopeOfActivity' => array(self::BELONGS_TO, 'ScopeOfActivity', 'scopeOfActivityId'),
			'patternsOfOwnership' => array(self::BELONGS_TO, 'PatternsOfOwnership', 'patternsOfOwnershipId'),
			'transport' => array(self::HAS_MANY, 'MyTransport', 'userId'),
		);
	}


	public function scopes()
	{
		return array(
			'juridical' => array('condition' => 'role = :r', 'params' => array(':r' => self::ROLE_JURIDICAL_FACE)),
			'physical' => array('condition' => 'role = :r', 'params' => array(':r' => self::ROLE_PHYSICAL_FACE)),
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
			'scopeOfActivityId' => 'Сфера деятельности',
			'cityId' => 'Город',
			'patternsOfOwnershipId' => 'Форма собственности',
			'address' => 'Адрес',
			'companyName' => 'Название компании',
			'info' => 'Описание',
			'tin' => 'ИНН',
			'active' => 'Active',
			'updated_timestamp' => 'Updated Timestamp',
			'created_timestamp' => 'Created Timestamp',
		);
	}

	public $orderBy = null;

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
		$criteria->compare('User.scopeOfActivityId', $this->scopeOfActivityId);
		$criteria->compare('User.cityId', $this->cityId);
		$criteria->compare('User.patternsOfOwnershipId', $this->patternsOfOwnershipId);
		$criteria->compare('User.address', $this->address, true);
		$criteria->compare('User.companyName', $this->companyName, true);
		$criteria->compare('User.info', $this->info, true);
		$criteria->compare('User.tin', $this->tin, true);
		$criteria->compare('User.active', $this->active);

		if ( $this->orderBy ) {
			switch ($this->orderBy) {
				case 'desc' :
					{
					if ( $this->role == self::ROLE_JURIDICAL_FACE ) {
						$criteria->order = 'User.companyName desc';
					} else {
						$criteria->order = 'User.name desc';
					}
					}
					break;
				case 'asc' :
				default:
					if ( $this->role == self::ROLE_JURIDICAL_FACE ) {
						$criteria->order = 'User.companyName asc';
					} else {
						$criteria->order = 'User.name asc';
					}
			}
		}

		return new ActiveDataProvider($this, array(
												  'criteria' => $criteria,
											 ));
	}

	public function beforeValidate()
	{
		if ( $this->role == self::ROLE_PHYSICAL_FACE ) {
			$this->setScenario('physical');
		} elseif ( $this->role == self::ROLE_JURIDICAL_FACE ) {
			$this->setScenario('juridical');
		} else {
			throw new CException('Not available role');
		}

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

	public function getFavoriesCount()
	{

		return count(Favorite::model()->findAllBySql('
		select f.* FROM Favorite `f`
		LEFT JOIN Tender ON tenderId = modelId AND modelName=\'Tender\'
		LEFT JOIN Transport ON transportId = modelId AND modelName=\'Transport\'
		LEFT JOIN Cargo ON cargoId = modelId AND modelName=\'Cargo\'
		LEFT JOIN User ON User.userId = modelId AND modelName=\'User\'
		where
		f.userId = :u AND (
			NOT ISNULL( tenderId )
			OR NOT ISNULL( cargoId )
			OR NOT ISNULL( User.userId )
			OR NOT ISNULL( transportId )
		)', array(
				 ':u' => Yii::app()->user->id)
		));
	}

	public function getTransportCount()
	{
		return MyTransport::model()->count();
	}

	public function getOrdersCount(){
			$sql = "select count(*) from (
			select cargoId as `key`,created_timestamp,userId,'Cargo' as modelName, 'Груз' as `name` from Cargo where userId = {$this->userId}
			AND active = 1
			UNION
			select transportId,created_timestamp,userId,'Transport','Транспорт' from Transport where userId = {$this->userId}
			AND type = '0' AND active = 1
			UNION
			select tenderId,created_timestamp,userId,'Tender', 'Тендер' from Tender where userId = {$this->userId} AND active = 1
		) t";

		$r = Yii::app()->db->createCommand($sql)->queryRow(false);
		return $r[0];
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
			return $this->patternsOfOwnership->name . ' "' . $this->companyName . '"';
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