<?php
/** @var AhorroRetiroController $this */
/** @var AhorroRetiro $model */
$this->menu = array(
//    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('create'),
//    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
//    ),
    array('label' => Yii::t('AweCrud.app', 'Retirar Ahorros'), 'icon' => 'exchange', 'url' => array('createRetiro'),
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-fire-extinguisher"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo AhorroRetiro::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

            <?php 
        $this->widget('bootstrap.widgets.TbGridView',array(
        'id' => 'ahorro-retiro-grid',
        'type' => 'striped bordered hover advance',
        'dataProvider' => $model->search(),
        'columns' => array(
                   array(
                    'name' => 'socio_id',
                    'value' => '$data->socio->nombre_formato'
                ),
                       array(
                    'name' => 'sucursal_id',
                    'value' => '$data->sucursal'
                ),
                        'cantidad',
                        array(
                    'name' => 'fecha_retiro',
                    'value' => 'Util::FormatDate($data->fecha_retiro,"d/m/Y")',
                ),
                          array(
                    'name' => 'entidad_bancaria_id',
                    'value' => '$data->entidadBancaria'
                ),
//                        'usuario_creacion_id',
                            
                        'numero_cheque',
                        
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