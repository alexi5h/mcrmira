<?php
/** @var CreditoAmortizacionController $this */
/** @var CreditoAmortizacion $model */
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('create'), 
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-fire-extinguisher"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo CreditoAmortizacion::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

            <?php 
        $this->widget('bootstrap.widgets.TbGridView',array(
        'id' => 'credito-amortizacion-grid',
        'type' => 'striped bordered hover advance',
        'dataProvider' => $model->search(),
        'columns' => array(
                    'nro_cuota',
                        'fecha_pago',
                        'cuota',
                        'interes',
                        'mora',
                        array(
                    'name' => 'estado',
                    'filter' => array('DEUDA'=>'DEUDA','PAGADO'=>'PAGADO',),
                ),
                            /*
                        array(
                    'name' => 'credito_id',
                    'value' => 'isset($data->credito) ? $data->credito : null',
                    'filter' => CHtml::listData(Credito::model()->findAll(), 'id', Credito::representingColumn()),
                ),
                        */
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update} {delete}',
                    'afterDelete' => 'function(link,success,data){ 
                    if(success) {
                         $("#flashMsg").empty();
                         $("#flashMsg").css("display","");
                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
                    }
                    }',
                    'buttons' => array(
                        'update' => array(
                            'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
                            'options' => array('title' => 'Actualizar'),
                            'imageUrl' => false,
                             //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
                        ),
                        'delete' => array(
                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
                            'options' => array('title' => 'Eliminar'),
                            'imageUrl' => false,
                            //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
                        ),
                    ),
                    'htmlOptions' => array(
                        'width' => '80px'
                    )
                ),
        ),
        )); ?>
    </div>
</div>