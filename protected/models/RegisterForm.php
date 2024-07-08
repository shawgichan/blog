<?php

class RegisterForm extends CFormModel
{
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;

    public function rules()
    {
        return array(
            array('username, email, password, passwordConfirm', 'required'),
            array('username, email', 'length', 'max'=>50),
            array('password', 'length', 'min'=>6, 'max'=>40),
            array('passwordConfirm', 'compare', 'compareAttribute'=>'password'),
            array('email', 'email'),
            array('username, email', 'unique', 'className'=>'User'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => 'Confirm Password',
        );
    }
}
