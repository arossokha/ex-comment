<?php

/**
 * This is the model class for table "Page".
 *
 * The followings are the available columns in table 'Page':
 * @property integer $pageId
 * @property string $path
 * @property string $text
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class Page extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Page the static model class
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
		return 'Page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('path, text', 'required'),
			array('path', 'unique'),
			array('path', 'length', 'max' => 100),
			array('text, created_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pageId, path, text, updated_timestamp, created_timestamp', 'safe', 'on' => 'search'),
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
			'pageId' => 'Page',
			'path' => 'Path',
			'text' => 'Text',
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

		$criteria->compare('pageId', $this->pageId);
		$criteria->compare('path', $this->path, true);
		$criteria->compare('text', $this->text, true);
		$criteria->compare('updated_timestamp', $this->updated_timestamp, true);
		//		$criteria->compare('created_timestamp',$this->created_timestamp,true);

		return new ActiveDataProvider($this, array(
												  'criteria' => $criteria,
											 ));
	}

	public function behaviors()
	{
		$bs = array(
			'AdminBehavior' => array(
				'class' => 'application.admin.components.behaviours.AdminBehavior',
				'fields' => array(
					array(
						'name' => 'Путь',
						'attribute' => 'path',
						'type' => 'text',
					),
					array(
						'name' => 'Контент',
						'attribute' => 'text',
						'type' => 'textEditor',
					),
				),
				'columns' => array(
					'pageId',
					'path'
				)
			)
		);

		return CMap::mergeArray(parent::behaviors(), $bs);
	}
}