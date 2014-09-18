<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';
	public $description = '';
	public $keywords = '';
	public $footerLogoPath = '/images/footer_logo.gif';
	public $footerLogoUrl = '/';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * init controller
	 */
	public function init()
	{
		/**
		 * always include jquery
		 */
		$cs = Yii::app()->getClientScript();
		$cs->packages = array(
			'jquery.ui' => array(
				'js' => array('jui/js/jquery-ui.min.js'),
				'css' => array('jui/css/base/jquery-ui.css'),
				'depends' => array('jquery'),
			),
		);
		$cs->registerCoreScript('jquery.ui');
		Yii::app()->clientScript->registerScriptFile('/js/uniform.js', CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile('/js/main.js', CClientScript::POS_HEAD);

		return parent::init();
	}
}