<?php

class m120904_170418_user extends CDbMigration
{
	public function up()
	{
		$this->createTable('User', array(
										'userId' => 'pk',
										'name' => 'varchar(20)',
										'lastName' => 'varchar(20)',
										'phone' => 'varchar(30)',
										'url' => 'varchar(100)',
										'email' => 'varchar(50)',
										'login' => 'varchar(20)',
										'password' => 'varchar(40)',
										'salt' => 'varchar(100)',
										'confirmCode'=> 'varchar(40)',
										'confirmed'=> 'int(1) DEFAULT 0',
										'role' => 'int(2)',
										'info' => 'text',
										'active' => 'int(1) DEFAULT 1',
										'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
										'created_timestamp' => 'timestamp',
								   ), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('User');
	}
}
