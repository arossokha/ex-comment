<?php
/**
 * Widget abstract class for all widgets foa admin panel
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
abstract class AdminWidget extends CWidget
{
	/**
	 * widget params uses to give all data to widget
	 * @var array
	 */
	public $params = array();

	/**
	 * Name of widget
	 * @var string
	 */
	public $name;

	/**
	 * Id of  block what wrapped widget
	 * @var string
	 */
	protected $blockId = 'crb';

	public function run()
	{
		throw new CException('Not implemented in ' . get_called_class());
	}

	/**
	 * @return string
	 */
	public function getBlockId()
	{
		return $this->blockId;
	}

	/**
	 * return data of widget by it path
	 * @static
	 * @param $path string
	 * @return bool | array
	 */
	public static function getWidgetDataByPath($path)
	{

		foreach (Yii::app()->params['layout']['panelSettings'] as $item) {
			if ( !strcasecmp($item['path'], $path) ) {
				return $item;
			}
		}
		return false;
	}

	/**
	 * Return name of widget for selected action
	 * @static
	 * @param string $action
	 * @return bool | string widget name
	 */
	public static function getWidgetNameByAction($action)
	{
		switch ($action) {
			case 'sort':
				return 'SortWidget';
			case 'create':
			case 'update':
				return 'ModelWidget';
			case 'delete':
				return 'DeleteWidget';
		}

		return false;
	}
}
