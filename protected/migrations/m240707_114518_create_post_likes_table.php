<?php

class m240707_114518_create_post_likes_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('post_likes', array(
            'id' => 'pk',
            'post_id' => 'integer NOT NULL',
            'user_id' => 'integer NOT NULL',
            'created_at' => 'datetime DEFAULT CURRENT_TIMESTAMP',
        ));
    }

    public function down()
    {
        $this->dropTable('post_likes');
    }

    /*
    public function safeUp()
    {
        $this->up();
    }

    public function safeDown()
    {
        $this->down();
    }
    */
}
