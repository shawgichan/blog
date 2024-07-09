<?php

class m240709_022332_add_likes_column_to_blog_post extends CDbMigration
{
    public function up()
    {
        $this->addColumn('tbl_blog_post', 'likes', 'integer DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('tbl_blog_post', 'likes');
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
