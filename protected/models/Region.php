<?php
/**
 * This is the model class for table "Region".
 *
 * The followings are the available columns in table 'Region':
 * @property integer $regionId
 * @property integer $countryId
 * @property string $name
 */

class Region extends ActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Region the static model class
	 */
	public static function model($className = __CLASS__) {
		
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		
		return 'Region';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
			array(
				'regionId, countryId, name',
				'required'
			) ,
			array(
				'regionId, countryId',
				'numerical',
				'integerOnly' => true
			) ,
			array(
				'name',
				'length',
				'max' => 50
			) ,
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array(
				'regionId, countryId, name',
				'safe',
				'on' => 'search'
			) ,
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		
		return array(
			'country' => array(
				self::BELONGS_TO,
				'Country',
				'countryId'
			)
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		
		return array(
			'regionId' => 'Region',
			'countryId' => 'Country',
			'name' => 'Name',
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('regionId', $this->regionId);
		$criteria->compare('countryId', $this->countryId);
		$criteria->compare('name', $this->name, true);
		$criteria->order = 'name ASC';
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	protected static $nameById = array();
	public static function getNameById($id) {
		
		if (empty(self::$nameById[$id])) {
			$c = Region::model()->findByPk($id);
			
			if ($c) {
				self::$nameById[$id] = $c->name;
			}
		}
		
		return self::$nameById[$id];
	}
	public function behaviors() {
		$bs = array(
			'AdminBehavior' => array(
				'class' => 'application.admin.components.behaviours.AdminBehavior',
				'fields' => array(
					array(
						'name' => 'Регион',
						'attribute' => 'name',
						'type' => 'text',
					) ,
					array(
						'name' => 'Страна',
						'attribute' => 'countryId',
						'type' => 'dropdown',
						'data' => array(
							'model' => Country::model()->findAll() ,
							'valueField' => 'countryId',
							'textField' => 'name',
						)
					) ,
				) ,
				'columns' => array(
					'regionId',
					'name'
				)
			)
		);
		
		return CMap::mergeArray(parent::behaviors() , $bs);
	}
}