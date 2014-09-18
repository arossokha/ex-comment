<?php

/**
 * This is the model class for table "Currency".
 *
 * The followings are the available columns in table 'Currency':
 * @property integer $currencyId
 * @property string $name
 */
class Currency extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Currency the static model class
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
		return 'Currency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max' => 50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('currencyId, name', 'safe', 'on' => 'search'),
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
			'currencyId' => 'Currency',
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

		$criteria->compare('currencyId', $this->currencyId);
		$criteria->compare('name', $this->name, true);

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
						'name' => 'Валюта',
						'attribute' => 'name',
						'type' => 'text',
					)
				),
				'columns' => array(
					'currencyId',
					'name'
				)
			)
		);

		return CMap::mergeArray(parent::behaviors(), $bs);
	}
}