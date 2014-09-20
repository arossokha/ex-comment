<?php

class m140918_204927_comments extends CDbMigration
{
	public function up()
	{
		$this->createTable('Comment',array(
					'commentId' => 'pk',
					'name' => 'varchar(50)',
					'email' => 'varchar(50)',
					'text' => 'text',
					'pageId' => 'int(11)',
					'active' => 'int(1) DEFAULT 1',
					'updated_timestamp' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
					'created_timestamp' => 'timestamp',
				), 'ENGINE=InnoDB CHARSET=utf8');

		$this->addForeignKey('comment_page_fk','Comment','pageId','Page','pageId');
	}

	public function down()
	{
		$this->dropForeignKey('comment_page_fk','Comment');
		$this->dropTable('Comment');
	}

}