<?php
/** @var AhorroDepositoController $this */
/** @var AhorroDeposito $model */
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('createDeposito'),
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-fire-extinguisher"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo AhorroDeposito::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'ahorro-deposito-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->search(),
            'columns' => array(
                array(
                    'name' => 'socio_id',
                    'value' => 'CHtml::link($data->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view", array("id"=>$data->socio_id)))',
                    'type' => 'html'
                ),
                array(
                    'header' => 'Cédula',
                    'value' => '$data->socio->cedula'
                ),
                'cantidad',
                array(
                    'name' => 'fecha_comprobante_entidad',
                    'value' => 'Util::FormatDate($data->fecha_comprobante_entidad, "d/m/Y")',
                ),
//                        'entidad_bancaria_id',
                'cod_comprobante_entidad',
                array(
                    'name' => 'sucursal_comprobante_id',
                    'value' => '$data->sucursal'
                ),
//                'cod_comprobante_su',
            /*
              'fecha_comprobante_su',
              array(
              'name' => 'pago_id',
              'value' => 'isset($data->pago) ? $data->pago : null',
              'filter' => CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn()),
              ),
             */
//                array(
//                    'class' => 'CButtonColumn',
//                    'template' => '{update} {delete}',
//                    'afterDelete' => 'function(link,success,data){ 
//                    if(success) {
//                         $("#flashMsg").empty();
//                         $("#flashMsg").css("display","");
//                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
//                    }
//                    }',
//                    'buttons' => array(
//                        'update' => array(
//                            'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
//                            'options' => array('title' => 'Editar'),
//                            'imageUrl' => false,
//                             //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
//                        ),
//                        'delete' => array(
//                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                            'options' => array('title' => 'Eliminar'),
//                            'imageUrl' => false,
//                            //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
//                        ),
//                    ),
//                    'htmlOptions' => array(
//                        'width' => '80px'
//                    )
//                ),
            ),
        ));
        ?>
    </div>
</div>