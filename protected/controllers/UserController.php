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
            $user->attributes = $model->attributes;
            if($user->save())
            {
                Yii::app()->user->setFlash('success', 'Please check your email for verification link.');
                $this->redirect(array('site/index'));
            }
        }
    }
    $this->render('register',array('model'=>$model));
}

public function actionVerify($token)
{
    $user = User::model()->findByAttributes(array('verification_token' => $token));
    if($user !== null)
    {
        $user->is_verified = 1;
        $user->verification_token = null;
        if($user->save())
        {
            Yii::app()->user->setFlash('success', 'Your email has been verified. You can now log in.');
        }
        else
        {
            Yii::app()->user->setFlash('error', 'There was an error verifying your email.');
        }
    }
    else
    {
        Yii::app()->user->setFlash('error', 'Invalid verification token.');
    }
    $this->redirect(array('site/index'));
}
public function actionCheckEmail()
{
    if(Yii::app()->request->isAjaxRequest)
    {
        $email = Yii::app()->request->getPost('email');
        $user = User::model()->findByAttributes(array('email' => $email));
        echo CJSON::encode(array('exists' => ($user !== null)));
        Yii::app()->end();
    }
}
public function actionValidateEmail()
{
    $model = new RegisterForm;
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
        echo CActiveForm::validate($model, array('email'));
        Yii::app()->end();
    }
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
//	public function actionVerify()
//	{
 //   		$token = Yii::app()->request->getParam('token');
 //   
//    		if ($token) {
//        		$user = User::model()->findByAttributes(array('verification_token' => $token));
 //       
 //       		if ($user) {
   //         			$user->is_verified = 1;
       //     			$user->verification_token = null;
     //       			if ($user->save()) {
      //          			Yii::app()->user->setFlash('success', 'Your email has been verified. You can now log in.');
        //        			$this->redirect(array('user/login'));
          //  			} else {
            //    			Yii::app()->user->setFlash('error', 'There was an error verifying your email.');
 //           			}
   //     		} else {
     //       			Yii::app()->user->setFlash('error', 'Invalid verification token.');
       // 		}
    //		}
//
  //  	$this->render('verify');
//	}
//public function actionValidateEmail()
//{
//    $model = new RegisterForm;
 //   if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
   //     echo CActiveForm::validate($model, array('email'));
   //     Yii::app()->end();
   // }
//}
}
