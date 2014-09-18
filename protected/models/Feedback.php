<?php

/**
 * This is the model class for table "Feedback".
 *
 * The followings are the available columns in table 'Feedback':
 * @property integer $feedbackId
 * @property string $name
 * @property string $email
 * @property string $message
 * @property integer $userId
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class Feedback extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Feedback the static model class
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
		return 'Feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, message', 'required'),
			array('userId, active', 'numerical', 'integerOnly' => true),
			array('name, email', 'length', 'max' => 100),
			array('email', 'email'),
			array('message, created_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('feedbackId, name, email, message, userId, active, updated_timestamp, created_timestamp', 'safe', 'on' => 'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'feedbackId' => 'Feedback',
			'name' => 'Имя',
			'email' => 'Email',
			'message' => 'Сообщение',
			'userId' => 'User',
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

		$criteria->compare('feedbackId', $this->feedbackId);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('userId', $this->userId);
		$criteria->compare('active', $this->active);
		$criteria->compare('updated_timestamp', $this->updated_timestamp, true);
		$criteria->compare('created_timestamp', $this->created_timestamp, true);

		return new CActiveDataProvider($this, array(
												   'criteria' => $criteria,
											  ));
	}

	public function beforeValidate()
	{
		$this->userId = Yii::app()->user->id;
		return parent::beforeValidate();
	}

	public function show()
	{
		$data = "<span style='text-align: left; color:black;'>" . CHtml::encode($this->message) . "</span>";
		if ( $this->userId ) {

			if ( $this->user->role == User::ROLE_JURIDICAL_FACE ) {
				$d = " {$this->user->lastName} {$this->user->name} {$this->user->patronymic}";
				$d .= " - компания <a href=\"/user/view/{$this->user->primaryKey}\">" . $this->user->patternsOfOwnership->name.' "' .CHtml::encode($this->user->companyName) . "\" </a>";
			} else {
				$d = CHtml::link("{$this->user->lastName} {$this->user->name} {$this->user->patronymic}", '/user/view/' . $this->user->primaryKey). " - частное лицо ";
			}

			$data .= "<span style='text-align: left;'><i style='color: #666;'>" . date('d.m.y', strtotime($this->created_timestamp)) . " " . $d . "</i></span>";
		} else {
			$data .= "<span style='text-align: left;'><i style='color: #666;'>" . date('d.m.y', strtotime($this->created_timestamp)) . " " . $this->name . " ";
			$data .= $this->email . "</i></span>";
		}

		return $data;
	}

	public function defaultScope(){
		return array(
			'alias' => 'feedback',
			'order' => '1 DESC'
		);
	}
}