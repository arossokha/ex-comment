<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */

class AutoTimestampBehavior extends CActiveRecordBehavior
{

	/**
	 * Имя поля, хранящего время создания модели.
	 */
	public $created = 'created_timestamp';
	/**
	 * Имя поля, хранящего время изменения модели.
	 */
	public $modified = 'updated_timestamp';


	public function beforeSave($on)
	{
		$c = array_keys($this->Owner->tableSchema->columns);
		if ( in_array($this->modified, $c) && in_array($this->created, $c) ) {
			if ( $this->Owner->isNewRecord )
            {
                $c = strtotime($this->Owner->{$this->created});
                $l = strtotime('2010-01-01');
                if($l > $c) {
                    $this->Owner->{$this->created} = new CDbExpression('NOW()');
                }
            }
			else{
                $this->Owner->{$this->modified} = new CDbExpression('NOW()');
            }
		}

		return true;
	}
}
