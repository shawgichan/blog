<?php

class m240707_233323_create_user_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('tbl_user', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'verification_token' => 'string',
            'is_verified' => 'boolean DEFAULT 0',
        ));

        $this->createIndex('username_UNIQUE', 'tbl_user', 'username', true);
        $this->createIndex('email_UNIQUE', 'tbl_user', 'email', true);
    }

    public function down()
    {
        $this->dropTable('tbl_user');
    }
}
