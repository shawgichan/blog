<?php

class UserController extends Controller
{
    public function actionRegister()
    {
        $model = new RegisterForm;

        if(isset($_POST['RegisterForm']))
        {
            $model->attributes=$_POST['RegisterForm'];
            if($model->validate())
            {
                $user = new User;
                $user->username = $model->username;
                $user->email = $model->email;
            	$hashedPassword = CPasswordHelper::hashPassword($model->password);
            	Yii::log("Registering user: " . $model->username . ", Hashed password: " . $hashedPassword, CLogger::LEVEL_INFO);
            	$user->password = $hashedPassword;
                $user->verification_token = md5(mt_rand() . time());

                if($user->save())
                {
                Yii::log("User registered successfully: " . $model->username, CLogger::LEVEL_INFO);
                Yii::app()->user->setFlash('success', 'Registration successful. Please check your email for verification. Your verification token is: ' . $user->verification_token);
                $this->redirect(array('user/verify'));                }
            }
        }

        $this->render('register', array('model'=>$model));
    }
    public function actionLogin()
	{
    		$model = new LoginForm;

    		if (isset($_POST['LoginForm'])) {
        	$model->attributes = $_POST['LoginForm'];
        	if ($model->validate() && $model->login()) {
        	    $this->redirect(Yii::app()->user->returnUrl);
        	}
    		}

  		$this->render('login', array('model' => $model));
	}
	public function actionVerify()
	{
    		$token = Yii::app()->request->getParam('token');
    
    		if ($token) {
        		$user = User::model()->findByAttributes(array('verification_token' => $token));
        
        		if ($user) {
            			$user->is_verified = 1;
            			$user->verification_token = null;
            			if ($user->save()) {
                			Yii::app()->user->setFlash('success', 'Your email has been verified. You can now log in.');
                			$this->redirect(array('user/login'));
            			} else {
                			Yii::app()->user->setFlash('error', 'There was an error verifying your email.');
            			}
        		} else {
            			Yii::app()->user->setFlash('error', 'Invalid verification token.');
        		}
    		}

    	$this->render('verify');
	}
}
