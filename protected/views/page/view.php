<?php
$this->breadcrumbs=array(
	'Pages'=>array('index'),
	$model->pageId,
);

?>

<h1><?php echo $model->title; ?></h1>

<div>
	<?php
		echo $model->text;
	?>
</div>

<?php

	$this->renderPartial('application.views.comment.form',array(
			'page' => $model,
		));