<?php

/**
 * This is the model class for table "File".
 *
 * The followings are the available columns in table 'File':
 * @property integer $fileId
 * @property string $name
 * @property string $path
 * @property string $modelName
 * @property integer $modelId
 * @property integer $active
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class File extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
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
		return 'File';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('updated_timestamp', 'required'),
			array('modelId, active', 'numerical', 'integerOnly' => true),
			array('name', 'length', 'max' => 250),
			array('path', 'length', 'max' => 500),
			array('modelName', 'length', 'max' => 100),
			array('created_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fileId, name, path, modelName, modelId, active, updated_timestamp, created_timestamp', 'safe', 'on' => 'search'),
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
			'fileId' => 'File',
			'name' => 'Name',
			'path' => 'Path',
			'modelName' => 'Model Name',
			'modelId' => 'Model',
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

		$criteria->compare('fileId', $this->fileId);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('path', $this->path, true);
		$criteria->compare('modelName', $this->modelName, true);
		$criteria->compare('modelId', $this->modelId);
		$criteria->compare('active', $this->active);
		$criteria->compare('updated_timestamp', $this->updated_timestamp, true);
		$criteria->compare('created_timestamp', $this->created_timestamp, true);

		return new ActiveDataProvider($this, array(
												  'criteria' => $criteria,
											 ));
	}
}