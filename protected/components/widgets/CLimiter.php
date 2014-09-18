<?php

function processor($it)
{
	if ( $it == Yii::app()->user->getState('pageSize') ) {
		return $it;
	} else {
		return CHtml::link($it, '?pageSize=' . $it, array('class' => 'limiterItem'));
	}
}

/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class CLimiter extends CWidget
{
	public $max = 50;
	public $min = 10;
	public $step = 10;
	public $class = 'limiter';

	public function run()
	{
		//		$id = $this->getOwner()->getId();
		$limitersVal = range($this->min, $this->max, $this->step);
		$pageSize = Yii::app()->request->getParam('pageSize') ? Yii::app()->request->getParam('pageSize') : 10;
		Yii::app()->user->setState('pageSize', $pageSize);
		//		Yii::app()->user->setState('ownerId',$id);
		$data = array_map('processor', $limitersVal);
		echo '<div class="' . $this->class . '">Показывать по ' . implode(' ', $data) . '</div>';
	}
}
