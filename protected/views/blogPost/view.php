<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */

$this->breadcrumbs=array(
    'Blog Posts'=>array('index'),
    $model->title,
);

$this->menu=array(
    array('label'=>'List BlogPost', 'url'=>array('index')),
    array('label'=>'Create BlogPost', 'url'=>array('create')),
    array('label'=>'Update BlogPost', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete BlogPost', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage BlogPost', 'url'=>array('admin')),
);
?>

<h1>View BlogPost #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'title',
        'content',
        'user_id',
        'is_public',
        'created_at',
        'updated_at',
        'likes',
    ),
)); ?>

<div class="like-section">
    <?php echo CHtml::ajaxLink(
        'Like',
        array('blogPost/like', 'id'=>$model->id),
        array(
            'success'=>'js:function(data){
                var result = $.parseJSON(data);
                if(result.status == "success"){
                    $("#likes-count").html(result.likes);
                }
            }'
        ),
        array('id'=>'like-button-'.$model->id)
    ); ?>
    <span id="likes-count"><?php echo $model->likes; ?></span> likes
</div>
