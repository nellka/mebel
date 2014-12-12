<?php

class m111105_052910_add_message_table extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `message` (
        `id` bigint(20) UNSIGNED  NOT NULL AUTO_INCREMENT,
        `id_from` bigint(20) NOT NULL,
        `id_to` bigint(20) NOT NULL,
        `datestamp` int(11) unsigned not null ,
        `viewed` tinyint(1) not null default 0,
        `deleted` tinyint(1) not null default 0,
        `message` text not null default '',
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=cp1251");
        $this->execute('ALTER TABLE  `message` ADD INDEX (  `id_from` )');
        $this->execute('ALTER TABLE  `message` ADD INDEX (  `id_to` )');
	}

	public function down()
	{
		$this->dropTable('mesage');

	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}