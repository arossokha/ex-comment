<?php

class m120909_150815_files extends CDbMigration
{
	public function up()
	{

		$this->createTable('File', array(
										'fileId' => 'pk',
										'name' => 'varchar(250)',
										'path' => 'varchar(500)',
										'modelName' => 'varchar(100)',
										'modelId' => 'int(11)',
										'active' => 'int(1) DEFAULT 1',
										'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
										'created_timestamp' => 'timestamp',
								   ), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('File');
	}

}