<?php

class m240705_174409_create_user_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('user', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'email' => 'string NOT NULL',
			'token' => 'text NULL',
			'status' => 'boolean default 1',
            'email_verified' => 'boolean default 0',
            'created_at' => 'datetime DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ));
    }

    public function down()
    {
        $this->dropTable('user');
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
