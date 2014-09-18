<?php
Yii::import('application.components.DateFormatter');
/**
 * Use this model for generate other models
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class ActiveRecord extends CActiveRecord
{
	public function behaviors()
	{
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'application.components.behaviors.AutoTimestampBehavior',
			)
		);
	}

	protected static $defaultScopeEnable = true;

	public static function disableDefaultScope()
	{
		self::$defaultScopeEnable = false;
	}

	public static function enableDefaultScope()
	{
		self::$defaultScopeEnable = true;
	}

	/**
	 * Update standart delete action
	 */
	public function delete() {

		$columns = $this->tableSchema->columns;

		if(array_key_exists('active', $columns)) {
			if($this->beforeDelete())
			{
				$this->active = 0;
				$res = $this->save(false);
				$this->afterDelete();
				return $res;
			}
		}

		return parent::delete();
	}
}
