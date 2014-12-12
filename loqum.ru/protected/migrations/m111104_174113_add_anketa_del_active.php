<?php

class m111104_174113_add_anketa_del_active extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `anketa` ADD  `isdeleted` BOOL NOT NULL DEFAULT  '0' AFTER  `last_visit` ,
        ADD  `isinactive` BOOL NOT NULL DEFAULT  '0' AFTER  `isdeleted`");
  //      return true;
	}

	public function down()
	{
		$this->dropColumn('anketa','isdeleted');
        $this->dropColumn('anketa','isinactive');
        //echo "m111104_174113_add_anketa_del_active does not support migration down.\n";
//		return true;
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