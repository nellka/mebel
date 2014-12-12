<?php

class m111219_154044_add_anketa_first_visit extends CDbMigration
{
    public function up()
    {
        $this->execute('ALTER TABLE  `anketa` ADD  `first_visit` INT UNSIGNED NOT NULL AFTER  `mainphoto`');
    }

    public function down()
    {

        $this->execute('ALTER TABLE  `anketa` DROP  `first_visit` ');
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