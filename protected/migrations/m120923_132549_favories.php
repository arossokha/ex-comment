<?php

class m120923_132549_favories extends CDbMigration
{
	public function up()
	{

		$this->createTable('Favorite', array(
											'favoriteId' => 'pk',
											'modelName' => 'varchar(100)',
											'modelId' => 'int(11)',
											'userId' => 'int(11)',
											'active' => 'int(1) DEFAULT 1',
											'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
											'created_timestamp' => 'timestamp',
									   ), 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('Favorite');
	}
}