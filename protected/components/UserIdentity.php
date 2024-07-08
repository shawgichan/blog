<?php

class UserIdentity extends CUserIdentity
{
    private $_id;

public function authenticate()
{
    $user = User::model()->findByAttributes(array('username' => $this->username));
    if ($user === null) {
        $this->errorCode = self::ERROR_USERNAME_INVALID;
    } else if (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
        $this->errorCode = self::ERROR_PASSWORD_INVALID;
    } else if (!$user->is_verified) {
        $this->errorCode = self::ERROR_USERNAME_INVALID;
        $this->errorMessage = 'Please verify your email address.';
    } else {
        $this->_id = $user->id;
        $this->setState('username', $user->username);
        $this->setState('is_verified', $user->is_verified);
        $this->errorCode = self::ERROR_NONE;
    }
    return !$this->errorCode;
}
    public function getId()
    {
        return $this->_id;
    }
}
