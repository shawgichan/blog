<?php

class User extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'tbl_user';
    }

    public function rules()
    {
        return array(
            array('username, password, email', 'required'),
	    array('is_verified', 'numerical', 'integerOnly'=>true),
            array('username, email', 'unique'),
            array('email', 'email'),
            array('username', 'length', 'max'=>50),
            array('password', 'length', 'min'=>6, 'max'=>255),
            array('verification_token', 'length', 'max'=>255),
            array('is_verified', 'boolean'),
        );
    }
protected function beforeSave()
{
    if($this->isNewRecord)
    {
        $this->verification_token = Yii::app()->security->generateRandomString();
        $this->is_verified = 0;
    }
    return parent::beforeSave();
}

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'verification_token' => 'Verification Token',
            'is_verified' => 'Is Verified',
        );
    }
public function isAuthenticated()
{
    return !Yii::app()->user->isGuest;
}
}
