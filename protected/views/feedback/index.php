<h1>Отзывы пользователей о сайте</h1>
<!--<p>--><?php //echo CHtml::link('Оставить отзыв','/feedback/create');?><!-- </p>-->

<!--<div id="table" class="info five2 type4">-->
<?php $this->widget('application.components.widgets.GridView', array(
																	'id' => 'feedback-view',
																	'dataProvider' => $dataProvider,
																	//																	'itemView' => '_view',
																	'hideHeader' => true,
																	'template' => "<div id='table' class='info five2 type4'>{items}</div>\n{pager} {limiter}",
																	'columns' => array(
																		array(
																			'type' => 'raw',
																			'value' => '$data->show()'
																		)
																	),
															   )); ?>
