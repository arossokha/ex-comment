<h1>Пользователь <?php echo $model->userId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
													'data' => $model,
													'attributes' => array(
														'userId',
														'name',
														'lastName',
														'phone',
														'email',
														'login',
														'password',
														'salt',
														'role',
														'active',
														'updated_timestamp',
														'created_timestamp',
													),
											   )); ?>
