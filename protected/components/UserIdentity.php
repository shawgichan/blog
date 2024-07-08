<?php

class UserIdentity extends CUserIdentity
{
    private $_id;

public function authenticate()
{
    Yii::log("Attempting to authenticate user: " . $this->username, CLogger::LEVEL_INFO);
    
    $user = User::model()->findByAttributes(array('username' => $this->username));
    if ($user === null) {
        Yii::log("User not found: " . $this->username, CLogger::LEVEL_INFO);
        $this->errorCode = self::ERROR_USERNAME_INVALID;
    } else {
        Yii::log("User found. Stored hash: " . $user->password, CLogger::LEVEL_INFO);
        Yii::log("Provided password: " . $this->password, CLogger::LEVEL_INFO);
        
        if (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
            Yii::log("Password verification failed for user: " . $this->username, CLogger::LEVEL_INFO);
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else if (!$user->is_verified) {
            Yii::log("User not verified: " . $this->username, CLogger::LEVEL_INFO);
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = 'Please verify your email address.';
        } else {
            Yii::log("Authentication successful for user: " . $this->username, CLogger::LEVEL_INFO);
            $this->_id = $user->id;
            $this->setState('username', $user->username);
            $this->errorCode = self::ERROR_NONE;
        }
    }
    return !$this->errorCode;
}
    public function getId()
    {
        return $this->_id;
    }
}
