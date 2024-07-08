<?php

class m240708_041416_create_blog_post_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('tbl_blog_post', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'content' => 'text NOT NULL',
            'user_id' => 'integer NOT NULL',
            'is_public' => 'boolean DEFAULT 1',
            'created_at' => 'datetime NOT NULL',
            'updated_at' => 'datetime NOT NULL',
        ));

        $this->addForeignKey('fk_blog_post_user', 'tbl_blog_post', 'user_id', 'tbl_user', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx_blog_post_user', 'tbl_blog_post', 'user_id');
    }

    public function down()
    {
        $this->dropTable('tbl_blog_post');
    }
}
