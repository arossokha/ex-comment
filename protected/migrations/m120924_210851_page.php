<?php

class m120924_210851_page extends CDbMigration
{
	public function up()
	{

		$this->createTable('Page', array(
										'pageId' => 'pk',
										'path' => 'varchar(100)',
										'text' => 'text',
										'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
										'created_timestamp' => 'timestamp',
								   ), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('Page');
	}
}
