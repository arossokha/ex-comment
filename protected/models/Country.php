<?php
/**
 * This is the model class for table "Country".
 *
 * The followings are the available columns in table 'Country':
 * @property integer $countryId
 * @property string $name
 */

class Country extends ActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className = __CLASS__) {
		
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		
		return 'Country';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
			array(
				'countryId, name',
				'required'
			) ,
			array(
				'countryId',
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
				'countryId, name',
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
		
		return array();
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		
		return array(
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
		$criteria->compare('countryId', $this->countryId);
		$criteria->compare('name', $this->name, true);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	protected static $nameById = array();
	public static function getNameById($id) {
		
		if (!$id) {
			
			return '';
		}
		
		if (empty(self::$nameById[$id])) {
			$c = Country::model()->findByPk($id);
			
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
						'name' => 'Страна',
						'attribute' => 'name',
						'type' => 'text',
					)
				) ,
				'columns' => array(
					'countryId',
					'name',
				)
			)
		);
		
		return CMap::mergeArray(parent::behaviors() , $bs);
	}
}
