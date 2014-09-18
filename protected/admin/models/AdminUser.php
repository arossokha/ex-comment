<?php

/**
 * This is the model class for table "AdminUser".
 *
 * The followings are the available columns in table 'AdminUser':
 * @property integer $adminUserId
 * @property string $name
 * @property string $lastName
 * @property string $phone
 * @property string $email
 * @property string $login
 * @property string $password
 * @property string $salt
 * @property integer $role
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class AdminUser extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminUser the static model class
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
		return 'AdminUser';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role, active', 'numerical', 'integerOnly' => true),
			array('name, lastName, phone', 'length', 'max' => 20),
			array('email, login', 'length', 'max' => 50),
			array('password', 'length', 'max' => 40),
			array('salt', 'length', 'max' => 100),
			array('created_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('adminUserId, name, lastName, phone, email, login, password, salt, role, active, updated_timestamp, created_timestamp', 'safe', 'on' => 'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'adminUserId' => 'User',
			'name' => 'Name',
			'lastName' => 'Last Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'login' => 'Login',
			'password' => 'Password',
			'salt' => 'Salt',
			'role' => 'Role',
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

		$criteria->compare('adminUserId', $this->adminUserId);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('lastName', $this->lastName, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('login', $this->login, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('salt', $this->salt, true);
		$criteria->compare('role', $this->role);
		$criteria->compare('active', $this->active);
//		$criteria->compare('updated_timestamp', $this->updated_timestamp, true);
//		$criteria->compare('created_timestamp', $this->created_timestamp, true);

		return new CActiveDataProvider($this, array(
												   'criteria' => $criteria,
											  ));
	}

    public function beforeSave() {
        if($this->password) {
            $this->password = Security::cryptPassword($this->password, '');
        }
        return parent::beforeSave();
    }

	public function behaviors()
	{
		$bs = array(
			'AdminBehavior' => array(
				'class' => 'application.admin.components.behaviours.AdminBehavior',
				'fields' => array(
					array(
						'name' => 'Email',
						'attribute' => 'email',
						'type' => 'text',
					),
					array(
						'name' => 'Логин',
						'attribute' => 'login',
						'type' => 'text',
					),
					array(
						'name' => 'Пароль',
						'attribute' => 'password',
						'type' => 'password',
					),
					array(
						'name' => 'Имя',
						'attribute' => 'name',
						'type' => 'text',
					),
					array(
						'name' => 'Фамилия',
						'attribute' => 'lastName',
						'type' => 'text',
					),
					array(
						'name' => 'Телефон',
						'attribute' => 'phone',
						'type' => 'text',
					),
				),
				'columns' => array(
					'adminUserId',
					'name',
					'lastName',
					'email',
					'phone',
				)
			)
		);

		return CMap::mergeArray(parent::behaviors(), $bs);
	}
}