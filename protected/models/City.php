<?php

/**
 * This is the model class for table "City".
 *
 * The followings are the available columns in table 'City':
 * @property integer $cityId
 * @property string $name
 */
class City extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return City the static model class
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
		return 'City';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, countryId', 'required'),
			array('name', 'length', 'max' => 50),
			array('regionId','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cityId, name', 'safe', 'on' => 'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'countryId'),
			'region' => array(self::BELONGS_TO, 'Region', 'regionId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cityId' => 'City',
			'name' => 'Name',
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

		$criteria->compare('cityId', $this->cityId);
		$criteria->compare('name', $this->name, true);
		$criteria->order = 'name ASC';

		return new ActiveDataProvider($this, array(
												  'criteria' => $criteria
											 ));
	}

	public function behaviors()
	{
		$bs = array(
			'AdminBehavior' => array(
				'class' => 'application.admin.components.behaviours.AdminBehavior',
				'fields' => array(
					array(
						'name' => 'Город',
						'attribute' => 'name',
						'type' => 'text',
					),
					array(
						'name' => 'Регион',
						'attribute' => 'regionId',
						'type' => 'autocomplete',
						'source' => Yii::app()->createUrl('site/region'),
						'valueField' => 'regionId',
						'textField' => 'name',
						'value' => $this->region->name,
					),
					array(
						'name' => 'Страна',
						'attribute' => 'countryId',
						'type' => 'dropdown',
						'data' => array(
							'model' => Country::model()->findAll(),
							'valueField' => 'countryId',
							'textField' => 'name',
						)
					),
				),
				'columns' => array(
					'cityId',
					'name'
				)
			)
		);

		return CMap::mergeArray(parent::behaviors(), $bs);
	}

}