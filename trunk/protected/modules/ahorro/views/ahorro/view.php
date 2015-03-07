<?php
/** @var AhorroController $this */
/** @var Ahorro $model */
Util::tsRegisterAssetJs('view.js');
$this->menu = array(
        //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . Ahorro::label(2), 'icon' => 'list', 'url' => array('index')),
//    array('label' => Yii::t('AweCrud.app', 'Manage'), 'icon' => 'icon-list', 'url' => array('admin')),
//    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'icon-plus',  'url' => array('create')),
        //array('label' => Yii::t('AweCrud.app', 'View'), 'icon' => 'eye-open', 'itemOptions'=>array('class'=>'active')),
        //array('label' => Yii::t('AweCrud.app', 'Update'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
        //array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
);
?>


<div class="row-fluid">
    <div class="span12">
        <h1 class="name-title"><i class="icon-tasks"></i> <?php echo Util::number_pad($model->id ,5) ?></h1>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <?php $this->renderPartial('portlets/_info', array('model' => $model)) ?>
    </div>

    <div class="span6">
        <?php $this->renderPartial('portlets/_depositos', array('model' => $model)); ?>
    </div>
</div>