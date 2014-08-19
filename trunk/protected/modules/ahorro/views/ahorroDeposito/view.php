<?php
/** @var AhorroDepositoController $this */
/** @var AhorroDeposito $model */

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . AhorroDeposito::label(2), 'icon' => 'list', 'url' => array('index')),
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
             'entidad_bancaria_id',
             'cod_comprobante_entidad',
             'fecha_comprobante_entidad',
             'sucursal_comprobante_id',
             'cod_comprobante_su',
             'fecha_comprobante_su',
             array(
			'name' => 'pago_id',
			'value'=>($model->pago !== null) ? CHtml::link($model->pago, array('/ahorro/view', 'id' => $model->pago->id)).' ' : null,
			'type' => 'html',
		),
	),
)); ?>
</fieldset>