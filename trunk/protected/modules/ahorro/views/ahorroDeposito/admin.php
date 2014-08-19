<?php
/** @var AhorroDepositoController $this */
/** @var AhorroDeposito $model */
$this->menu = array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . AhorroDeposito::label(2), 'icon' => 'list', 'url' => array('index')),
    array('label' => "<div>" . CHtml::image(Yii::app()->baseUrl . "/images/topbar/administrar.png") . "</div>" . Yii::t('AweCrud.app', 'Manage'), 'itemOptions' => array('class' => 'active')),
    array('label' => "<div>" . CHtml::image(Yii::app()->baseUrl . "/images/topbar/nuevo.png") . "</div>" . Yii::t('AweCrud.app', 'Create'), 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('ahorro-deposito-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<fieldset>
    <legend>
        <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo AhorroDeposito::label(2) ?>    </legend>

    <div class="well">
        <?php 
        $this->widget('bootstrap.widgets.TbGridView',array(
    'id' => 'ahorro-deposito-grid',
    'type' => 'striped condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
            'cantidad',
                'entidad_bancaria_id',
                'cod_comprobante_entidad',
                'fecha_comprobante_entidad',
                'sucursal_comprobante_id',
                'cod_comprobante_su',
                    /*
                'fecha_comprobante_su',
                array(
                    'name' => 'pago_id',
                    'value' => 'isset($data->pago) ? $data->pago : null',
                    'filter' => CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn()),
                ),
                */
    array(
    'class' => 'bootstrap.widgets.TbButtonColumn',
    'template' => '{view} {update}'
    ),
    ),
    )); ?>
    </div>
</fieldset>