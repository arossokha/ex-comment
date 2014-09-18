<?php

class m120902_170534_adminUsers extends CDbMigration
{
	public function up()
	{
		$this->createTable('AdminUser', array(
											 'adminUserId' => 'pk',
											 'name' => 'varchar(20)',
											 'lastName' => 'varchar(20)',
											 'phone' => 'varchar(20)',
											 'email' => 'varchar(50)',
											 'login' => 'varchar(50)',
											 'password' => 'varchar(40)',
											 'salt' => 'varchar(100)',
											 'role' => 'int(2)',
											 'active' => 'int(1) DEFAULT 1',
											 'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
											 'created_timestamp' => 'timestamp',
										), 'ENGINE=InnoDB CHARSET=utf8');

		$this->execute("INSERT INTO `AdminUser` (`adminUserId`, `name`, `lastName`, `phone`, `email`, `login`, `password`, `salt`, `role`, `active`, `updated_timestamp`, `created_timestamp`) 
				VALUES
				(1, 'Admin', 'admin', NULL, 'pokemon4ik2008@i.ua', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, 1, '2012-09-24 21:42:10', '2012-09-24 21:42:10')");

	}

	public function down()
	{
		$this->dropTable('AdminUser');
	}

}
