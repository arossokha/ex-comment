<?php
/**
 * @todo : add comments here
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */

Yii::import('zii.widgets.grid.CGridView');

class GridView extends CGridView
{

	public $limiter = array('class' => 'CLimiter');
	public $enableLimiter = true;
	//	public $template="{summary}\n{items}\n{pager} {limiter}";
	public $template = "{items}\n{pager} {limiter}";

	/**
	 * Renders the pager.
	 */
	public function renderLimiter()
	{
		if ( !$this->enableLimiter )
			return;
		Yii::import('application.components.widgets.*');
		$limiter = array();
		$class = 'CLimiter';
		if ( is_string($this->limiter) )
			$class = $this->limiter;
		else if ( is_array($this->limiter) ) {
			$limiter = $this->limiter;
			if ( isset($limiter['class']) ) {
				$class = $limiter['class'];
				unset($limiter['class']);
			}
		}

		$this->widget($class, $limiter);
	}
}
