<?php
/**
 * Active data provider for render widgets with CLinter
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class ActiveDataProvider extends CActiveDataProvider {

    public function __construct($modelClass, $config = array()) {
		$newConfig = CMap::mergeArray($config, array(
			'pagination' => array(
				'pageSize' => $this->getPageSize() ,
			) ,
		));
		parent::__construct($modelClass, $newConfig);
	}

	protected function getPageSize() {
		$s = Yii::app()->request->getParam('pageSize');
		$s = intval($s);
		
		if ($s > 0) {
			
			return $s;
		}
		
		return 10;
	}
}
