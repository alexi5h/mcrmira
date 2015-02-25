<?php
Util::tsRegisterAssetJs('view.js');
/** @var CreditoController $this */
/** @var Credito $model */
$this->menu = array(
        //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . Credito::label(2), 'icon' => 'list', 'url' => array('index')),
//    array('label' => "<div>" . CHtml::image(Yii::app()->baseUrl . "/images/topbar/administrar.png") . "</div>" . Yii::t('AweCrud.app', 'Manage'), 'url' => array('admin')),
//    array('label' => "<div>" . CHtml::image(Yii::app()->baseUrl . "/images/topbar/nuevo.png") . "</div>" .  Yii::t('AweCrud.app', 'Create'), 'url' => array('create')),
        //array('label' => Yii::t('AweCrud.app', 'View'), 'icon' => 'eye-open', 'itemOptions'=>array('class'=>'active')),
        //array('label' => Yii::t('AweCrud.app', 'Update'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
        //array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
);
?>

<div class="row-fluid">
    <div class="span12">
        <h1 class="name-title"><i class="icon-money"></i> <?php echo $model->id ?></h1>
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
<div class="row-fluid">
    <div class="span12">
        <?php $this->renderPartial('portlets/_amortizacion', array('model' => $model)) ?>
    </div>
</div>