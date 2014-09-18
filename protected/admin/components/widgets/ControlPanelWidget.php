<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class ControlPanelWidget extends CWidget
{
	/**
	 * Categories for control panel
	 * @var array of categories
	 * @example [['name' => 'Test',    'path' => 'test','class' => 'TestWidget']]
	 */
	public $categories = array();

	protected $mandatoryParameters = array('class', 'name', 'path');

	public function init()
	{

		/**
		 * validate if all params is set in config array
		 */
		//		$pathArray = array();
		//		array_walk($this->categories, function(&$item, $index) use (&$pathArray)
		//		{
		//			if ( in_array($item['path'], $pathArray) ) {
		//				throw new CException('Duplicate path -> index ' . $index);
		//			} else {
		//				array_push($pathArray, $item['path']);
		//			}
		//			foreach ($this->mandatoryParameters as $i) {
		//				if ( !array_key_exists($i, $item) ) {
		//					throw new CException('Key not exist ' . $i . ' by index ' . $index);
		//				}
		//			}
		//		});

		return parent::init();
	}

	public function run()
	{

		$this->render('controlPanel', array());
	}
}
