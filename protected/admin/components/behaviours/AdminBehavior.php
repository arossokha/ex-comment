<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class AdminBehavior extends CActiveRecordBehavior
{
	public $columns = array();
	public $fields = array();

	public function afterConstruct($e)
	{
		if ( empty($this->columns) || !is_array($this->columns) || count($this->columns) < 1 ) {
			throw new CException('No columns in settings of behaviour');
		}

		if ( empty($this->fields) || !is_array($this->fields) || count($this->fields) < 1 ) {
			throw new CException('No fields in settings of behaviour');
		}
		return parent::afterConstruct($e);
	}

	public function getFieldSettingsForAdminPanel()
	{
		return $this->fields;
	}

	public function getColumnSettingsForAdminPanel()
	{
		return $this->columns;
	}
}
