<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('pageId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->pageId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->updated_timestamp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_timestamp')); ?>:</b>
	<?php echo CHtml::encode($data->created_timestamp); ?>
	<br />

	<?php 

	// $this->widget('zii.widgets.CListView', array(
	// 	'dataProvider'=>$model->getCommentProvider(),
	// 	'itemView'=>'_viewComment',
	// )); 
	
	?>

</div>