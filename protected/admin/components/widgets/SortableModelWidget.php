<?php
/**
 */
class SortableModelWidget extends AdminWidget{

	protected $modelName;

	public function init()
{
	//		var_dump($this->params);
	$this->modelName = !is_array($this->params['model']) ? $this->params['model'] : $this->params['model']['class'];

	if ( $this->params['importPath'] ) {
		Yii::import($this->params['importPath']);
	}

	return parent::init();
}

	public function run()
{

	$model = new $this->modelName();
	if ( !in_array('CModel', class_parents($model)) ) {
		throw new CException('Not correct model class');
	}

	if ( isset($_POST[$this->modelName]) ) {
		$model->attributes = $_POST[$this->modelName];
	}

	$modelColumns = array_keys($model->tableSchema->columns);

	if ( $model->asa('AdminBehavior') ) {
		$columns = $model->getColumnSettingsForAdminPanel();
	} else {
		$columns = array($model->tableSchema->primaryKey, $modelColumns[1]);
	}

	//		var_dump($this->params);
	//		exit();

	$buttonColumn = array(
		'template' => '{sortUpButton} {sortDownButton} {update} {delete}',
		'class' => 'CButtonColumn',
		'deleteButtonUrl' => '"/admin/".$this->grid->owner->params["path"]."/delete/".$data->primaryKey',
		'updateButtonUrl' => '"/admin/".$this->grid->owner->params["path"]."/update/".$data->primaryKey',
		'buttons' => array(
			'sortUpButton' => array(
				'label' => 'up',
				'url' => '"/admin/".$this->grid->owner->params["path"]."/sort/up/".$data->primaryKey',
				'imageUrl' => '/images/admin/up.gif',
				'options' => array(),
				'click' => 'js:function(){
						var b = $(this).parents(".items").parent().attr("id");
						$.post($(this).attr("href"),{},function(data){
							$.fn.yiiGridView.update(b);
						});
						return false;
					}',
			),
			'sortDownButton' => array(
				'label' => 'down',
				'url' => '"/admin/".$this->grid->owner->params["path"]."/sort/down/".$data->primaryKey',
				'imageUrl' => '/images/admin/down.gif',
				'options' => array(),
				'click' => 'js:function(){
						var b = $(this).parents(".items").parent().attr("id");
						$.post($(this).attr("href"),{},function(data){
							$.fn.yiiGridView.update(b);
						});
						return false;
					}',
			)
		)
	);
	//		$buttonColumn = array();

	$this->render('sortablemodel', array(
		'model' => $model,
		'columns' => $columns,
		'buttonColumn' => $buttonColumn,
	));
}
}

