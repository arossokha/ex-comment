<?php

/**
 * This is the model class for table "Faq".
 *
 * The followings are the available columns in table 'Faq':
 * @property integer $faqId
 * @property string $question
 * @property string $answer
 * @property string $updated_timestamp
 * @property string $created_timestamp
 */
class Faq extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Faq the static model class
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
		return 'Faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('answer, question', 'required'),
			array('question', 'length', 'max'=>500),
			array('answer, created_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faqId, question, answer, updated_timestamp, created_timestamp', 'safe', 'on'=>'search'),
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
			'faqId' => 'Faq',
			'question' => 'Вопрос',
			'answer' => 'Ответ',
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

		$criteria=new CDbCriteria;

		$criteria->compare('faqId',$this->faqId);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('answer',$this->answer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors()
	{
		$bs = array(
			'AdminBehavior' => array(
				'class' => 'application.admin.components.behaviours.AdminBehavior',
				'fields' => array(
					array(
						'name' => 'Вопрос',
						'attribute' => 'question',
						'type' => 'textarea',
					), array(
						'name' => 'Ответ',
						'attribute' => 'answer',
						'type' => 'textEditor',
					),
				),
				'columns' => array(
					'faqId',
					'question'
				)
			)
		);

		return CMap::mergeArray(parent::behaviors(), $bs);
	}

}