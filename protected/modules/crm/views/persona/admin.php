<?php
/** @var PersonaController $this */
/** @var Persona $model */
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
        <h4> <i class="icon-fire-extinguisher"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo Persona::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'persona-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->de_tipo(Persona::TIPO_CLIENTE)->activos()->search(),
            'columns' => array(
                'primer_nombre',
                'segundo_nombre',
                'apellido_paterno',
                'apellido_materno',
                'cedula',
                'telefono',
                /*
                  'celular',
                  'email',
                  array(
                  'name' => 'estado',
                  'filter' => array('ACTIVO'=>'ACTIVO','INACTIVO'=>'INACTIVO',),
                  ),
                  'fecha_creacion',
                  'fecha_actualizacion',
                  'usuario_creacion_id',
                  'usuario_actualizacion_id',
                  'cliente_estado_id',
                  'aprobado',
                  'sucursal_id',
                  'direccion_domicilio_id',
                  'direccion_negocio_id',
                  'ruc',
                  array(
                  'name' => 'tipo',
                  'filter' => array('CLIENTE'=>'CLIENTE','GARANTE'=>'GARANTE',),
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
        ));
        ?>
    </div>
</div>