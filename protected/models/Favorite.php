<?php

/**
 * This is the model class for table "Favorite".
 *
 * The followings are the available columns in table 'Favorite':
 * @property integer $favoriteId
 * @property string $modelName
 * @property integer $modelId
 * @property integer $userId
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class Favorite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Favorite the static model class
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
		return 'Favorite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, modelId, modelName', 'required'),
			array('modelId, active, userId', 'numerical', 'integerOnly' => true),
			array('modelName', 'length', 'max' => 100),
			array('created_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('favoriteId, modelName, modelId, active, updated_timestamp, created_timestamp', 'safe', 'on' => 'search'),
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
			'favoriteId' => 'Favorite',
			'modelName' => 'Model Name',
			'modelId' => 'Model',
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

		$criteria->compare('favoriteId', $this->favoriteId);
		$criteria->compare('modelName', $this->modelName, true);
		$criteria->compare('modelId', $this->modelId);
		$criteria->compare('userId', $this->userId);
		$criteria->compare('active', $this->active);
		$criteria->compare('updated_timestamp', $this->updated_timestamp, true);
		$criteria->compare('created_timestamp', $this->created_timestamp, true);

		return new CActiveDataProvider($this, array(
												   'criteria' => $criteria,
											  ));
	}


	public function defaultScope()
	{
		return array(
			'alias' => 'favorite',
			'condition' => 'favorite.userId = ' . Yii::app()->user->id
		);
	}

	public static function getHtmlCode($model)
	{
		if ( $model instanceof ActiveRecord ) {
			if ( $model->primaryKey && !Yii::app()->user->IsGuest 
				&& strpos(Yii::app()->controller->route, 'orders') === false
				&& $model->userId != Yii::app()->user->id
				) {
				$modelClass = get_class($model);
				$modelId = $model->primaryKey;
				if ( !Favorite::model()->find('modelId = :mId AND modelName = :mN', array(':mId' => $modelId, ':mN' => $modelClass)) ) {
					return CHtml::link('Добавить в избранное', 'javascript:void(0);', array('class' => 'fav favoriteAdd')) .
						"<div style='display:none;' class='favoriteInfo'>"
						. CHtml::hiddenField('Favorite[modelId]', $modelId) .
						CHtml::hiddenField('Favorite[modelName]', $modelClass) .
						"</div>";
				}
			}
		}
		return "";
	}

	public function beforeValidate()
	{
		$this->userId = Yii::app()->user->id;
		return parent::beforeValidate();
	}

	/**
	 * get Favorite model by model name and Id
	 */
	public static function getFavoriteByModelNameAndId($model,$id) {
		return Favorite::model()->find('modelName = :model and modelId = :id',array(
			':id' => $id,
			':model' => $model,
			));
	}

	public function behaviors()
	{
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'application.components.behaviors.AutoTimestampBehavior',
			)
		);
	}
}