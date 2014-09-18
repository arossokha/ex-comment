<?php
$this->breadcrumbs = array(
	'Feedbacks' => array('index'),
	$model->name,
);

$this->menu = array(
	array('label' => 'List Feedback', 'url' => array('index')),
	array('label' => 'Create Feedback', 'url' => array('create')),
	array('label' => 'Update Feedback', 'url' => array('update', 'id' => $model->feedbackId)),
	array('label' => 'Delete Feedback', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->feedbackId), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Manage Feedback', 'url' => array('admin')),
);
?>

<h1>View Feedback #<?php echo $model->feedbackId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
													'data' => $model,
													'attributes' => array(
														'feedbackId',
														'name',
														'email',
														'message',
														'userId',
														'active',
														'updated_timestamp',
														'created_timestamp',
													),
											   )); ?>
