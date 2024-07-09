<?php

class BlogPostController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

public function accessRules()
{
    return array(
        array('allow',
            'actions'=>array('index', 'view'),
            'users'=>array('*'),
        ),
        array('allow',
            'actions'=>array('create', 'update', 'delete'),
            'expression'=>'$user->isAuthenticated() && $user->getState("is_verified")',
        ),
        array('deny',
            'users'=>array('*'),
        ),
    );
}
    public function actionView($id)
    {
        $this->render('view', array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionCreate()
    {
        $model=new BlogPost;

        if(isset($_POST['BlogPost']))
        {
            $model->attributes=$_POST['BlogPost'];
            $model->user_id = Yii::app()->user->id;
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['BlogPost']))
        {
            $model->attributes=$_POST['BlogPost'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

 //   public function actionIndex()
 //   {
 //       $dataProvider=new CActiveDataProvider('BlogPost');
//        $this->render('index',array(
//            'dataProvider'=>$dataProvider,
//        ));
//    }
public function actionIndex()
{
    $criteria = new CDbCriteria;
    if (Yii::app()->user->isGuest) {
        $criteria->condition = 'is_public = 1';
    }
    
    $dataProvider = new CActiveDataProvider('BlogPost', array(
        'criteria' => $criteria,
    ));

    $this->render('index', array(
        'dataProvider' => $dataProvider,
    ));
}
    public function actionLike($id)
    {
        if (Yii::app()->request->isAjaxRequest && !Yii::app()->user->isGuest) {
            $model = $this->loadModel($id);
            $model->likes += 1;
            if ($model->save()) {
                echo CJSON::encode(array('status' => 'success', 'likes' => $model->likes));
            } else {
                echo CJSON::encode(array('status' => 'error'));
            }
            Yii::app()->end();
        }
    }
    public function loadModel($id)
    {
        $model=BlogPost::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
protected function beforeAction($action)
{
    if (parent::beforeAction($action)) {
        if (in_array($action->id, array('create', 'update', 'delete'))) {
            if (Yii::app()->user->isGuest) {
                $this->redirect(array('site/login'));
                return false;
            }
            if (!Yii::app()->user->getState('is_verified')) {
                Yii::app()->user->setFlash('error', 'Your account needs to be verified before you can perform this action.');
                $this->redirect(array('site/index'));
                return false;
            }
        }
        return true;
    }
    return false;
}
}
