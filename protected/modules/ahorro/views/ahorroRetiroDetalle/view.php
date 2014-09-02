<?php
/** @var AhorroRetiroDetalleController $this */
/** @var AhorroRetiroDetalle $model */

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . AhorroRetiroDetalle::label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => "<div>" . CHtml::image(Yii::app()->baseUrl . "/images/topbar/administrar.png") . "</div>" . Yii::t('AweCrud.app', 'Manage'), 'url' => array('admin')),
    array('label' => "<div>" . CHtml::image(Yii::app()->baseUrl . "/images/topbar/nuevo.png") . "</div>" .  Yii::t('AweCrud.app', 'Create'), 'url' => array('create')),
    //array('label' => Yii::t('AweCrud.app', 'View'), 'icon' => 'eye-open', 'itemOptions'=>array('class'=>'active')),
    //array('label' => Yii::t('AweCrud.app', 'Update'), 'icon' => 'pencil', 'url' => array('update', 'id' => $model->id)),
    //array('label' => Yii::t('AweCrud.app', 'Delete'), 'icon' => 'trash', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => Yii::t('AweCrud.app', 'Are you sure you want to delete this item?'))),
    
);
?>

<fieldset>
    <legend><?php echo Yii::t('AweCrud.app', 'View'); ?> </legend>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data' => $model,
	'attributes' => array(
                  'cantidad',
             'ahorro_id',
             array(
			'name' => 'ahorro_retiro_id',
			'value'=>($model->ahorroRetiro !== null) ? CHtml::link($model->ahorroRetiro, array('/ahorroRetiro/view', 'id' => $model->ahorroRetiro->id)).' ' : null,
			'type' => 'html',
		),
	),
)); ?>
</fieldset>