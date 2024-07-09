<?php

class BlogPost extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'tbl_blog_post';
    }

    public function rules()
    {
        return array(
            array('title, content, user_id', 'required'),
            array('user_id', 'numerical', 'integerOnly'=>true),
            array('is_public', 'boolean'),
            array('title', 'length', 'max'=>255),
            array('created_at, updated_at', 'safe'),
            array('id, title, content, user_id, is_public, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'user_id' => 'Author',
            'is_public' => 'Is Public',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
            $this->created_at = new CDbExpression('NOW()');
        
        $this->updated_at = new CDbExpression('NOW()');
        
        return parent::beforeSave();
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('is_public',$this->is_public);
	$criteria->compare('likes', $this->likes);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('updated_at',$this->updated_at,true);
        
        if (isset($_GET['date_from']) && isset($_GET['date_to'])) {
            $criteria->addBetweenCondition('created_at', $_GET['date_from'], $_GET['date_to']);
        }

        
        if (isset($_GET['author'])) {
            $criteria->addCondition('user_id = :author');
            $criteria->params[':author'] = $_GET['author'];
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
