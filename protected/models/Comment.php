<?php

/**
 * This is the model class for table "Comment".
 *
 * The followings are the available columns in table 'Comment':
 * @property integer $commentId
 * @property string $name
 * @property string $email
 * @property string $text
 * @property integer $pageId
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 *
 * The followings are the available model relations:
 * @property Page $page
 */
class Comment extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Comment';
	}


	public $verifyCode;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, text', 'required'),
			array('pageId, active', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>50),
			array('email', 'email'),
			array('text, created_timestamp', 'safe'),
			array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('commentId, name, email, text, pageId, active, updated_timestamp, created_timestamp', 'safe', 'on'=>'search'),
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
			'page' => array(self::BELONGS_TO, 'Page', 'pageId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'commentId' => 'Comment',
			'name' => 'Name',
			'email' => 'Email',
			'text' => 'Text',
			'pageId' => 'Page',
			'active' => 'Active',
			'updated_timestamp' => 'Updated Timestamp',
			'created_timestamp' => 'Created Timestamp',
			'verifyCode' => 'Verification Code',
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

		$criteria=new CDbCriteria;

		$criteria->compare('commentId',$this->commentId);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('pageId',$this->pageId);
		// $criteria->compare('active',$this->active);
		// $criteria->compare('updated_timestamp',$this->updated_timestamp,true);
		// $criteria->compare('created_timestamp',$this->created_timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		$this->created_timestamp = date('Y-m-d H:i:s');
		return parent::beforeSave();
	}

	public function getTextWithLinks() 
	{
		$text = $this->text;
		$urlRegexp = "/(http|https|ftp|ftps)\:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(\/\S*)?/i";
		if(preg_match($urlRegexp, $text, $url)) {
			$text = preg_replace($urlRegexp, "<a target='_blank' href=\"{$url[0]}\">{$url[0]}</a> ", $text);
		}

		return $text;
	}
}