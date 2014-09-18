<?php
/**
 * Setting for site
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */
class Settings extends CFormModel
{

	public $name;
	public $about;
	public $adv;
	public $leftBanner;
	public $leftBannerUrl;
	public $feedbackEmail;
	public $contact;
	//	public $keywords;
	//	public $description;
	//	public $info;

	protected $fileName = 'settings.bin';

	public function init()
	{
		if ( file_exists($this->getSavePath() . $this->fileName) ) {
			$this->setAttributes(unserialize(file_get_contents($this->getSavePath() . $this->fileName)));
		}
		return parent::init();
	}

	public function rules()
	{
		return array(
			array('name, leftBanner, about, adv, contact', 'safe'),
			array('feedbackEmail','email')
			//			array('name, description, info, keywords', 'safe')
		);
	}

	public function save($runValidation = true, $attributes = null)
	{
		/**
		 * @todo get data by attribute names
		 */
		//		var_dump($this->getAttributes());
		//		var_dump($this->getSavePath());
		//		exit();
		//		throw new CException('Not inmplemented'.__FILE__);

		if ( !$runValidation || $this->validate($attributes) ) {
			return file_put_contents($this->getSavePath() . $this->fileName, serialize($this->getAttributes()));
		}
		return false;
	}

	protected function getSavePath()
	{
		return Yii::getPathOfAlias('application.admin.data') . DIRECTORY_SEPARATOR;
	}

	public function getIsNewRecord()
	{
		return false;
	}

	public function getFieldSettingsForAdminPanel()
	{

		return array(
			array(
				'name' => 'Имя',
				'attribute' => 'name',
				'type' => 'text',
			),
			array(
				'name' => 'Email для обратной связи',
				'attribute' => 'feedbackEmail',
				'type' => 'text',
			),
			array(
				'name' => 'Банер Url',
				'attribute' => 'leftBannerUrl',
				'type' => 'text',
			),
			array(
				'name' => 'О системе',
				'attribute' => 'about',
				'type' => 'textEditor',
			),
			array(
				'name' => 'Реклама',
				'attribute' => 'adv',
				'type' => 'textEditor',
			),
            array(
                'name' => 'Контакты',
                'attribute' => 'contact',
                'type' => 'textEditor',
            ),
			//			array(
			//				'name' => 'Описание',
			//				'attribute' => 'description',
			//				'type' => 'textEditor',
			//			),
			//			array(
			//				'name' => 'Информация',
			//				'attribute' => 'info',
			//				'type' => 'textarea',
			//			),
			//			array(
			//				'name' => 'Ключевые слова',
			//				'attribute' => 'keywords',
			//				'type' => 'date',
			//			),
		);
	}

}
