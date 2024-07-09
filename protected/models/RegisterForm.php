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
            array('email', 'validateEmail'),
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

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::model()->findByAttributes(array('email' => $this->email));
            if ($user !== null) {
                $this->addError($attribute, 'Email already in use.');
            }
        }
    }
}
