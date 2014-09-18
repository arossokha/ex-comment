<?php

class m120923_220530_feedback extends CDbMigration
{
	public function up()
	{

		$this->createTable('Feedback', array(
											'feedbackId' => 'pk',
											'name' => 'varchar(100)',
											'email' => 'varchar(100)',
											'message' => 'text',
											'userId' => 'int(11)',
											'active' => 'int(1) DEFAULT 1',
											'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
											'created_timestamp' => 'timestamp',
									   ), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('Feedback');
	}
}