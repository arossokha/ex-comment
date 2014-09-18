<?php
/**
 * Model manager view
 * @author: Artem Rossokha <artiom.rossokha@iqria.com>
 */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>
	<span class="info"> Управление "<?php echo $this->name;?>" </span>
</h3>

<!--<p>-->
<!--	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>-->
<!--	&lt;&gt;</b>-->
<!--	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.-->
<!--</p>-->

<?php
//echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button'));
?>
<div class="search-form" style="display:none">
	<?php
	//$this->renderPartial('_search',array(
	//										  'model'=>$model,
	//									 ));
	?>
</div><!-- search-form -->
<div class="clear"></div>

<?php echo CHtml::link('Создать "' . $this->name . '"', '/' . Yii::app()->request->pathInfo . '/create', array('class' => '')); ?>

<?php
$columns[] = $buttonColumn;
//var_dump($columns);
//exit();

$this->widget('application.components.widgets.GridView', array(
												 'id' => strtolower(get_class($model)) . '-grid',
												 'dataProvider' => $model->search(),
												 // 'filter'=>$model,
												 'columns' => $columns,
												'limiter' => array(
													'max' => 200,
													'min' => 50,
													'step' => 50,
												)
											)); ?>