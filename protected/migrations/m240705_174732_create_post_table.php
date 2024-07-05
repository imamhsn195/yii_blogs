<?php

class m240705_174732_create_post_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('post', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'content' => 'text NOT NULL',
            'author_id' => 'integer NOT NULL',
            'is_public' => 'boolean default 1',
            'created_at' => 'datetime NOT NULL',
            'updated_at' => 'datetime NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable('post');
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
