<div class="widget bluesky">
    <div class="widget-title">
        <h4><i class="icon-info-sign"></i> Informaci&oacute;n General</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
        </span>
    </div>
    <div class="widget-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'nombre_formato',
                'cedula',
                'ruc',
                'telefono',
                'celular',
                array(
                    'name' => 'email',
                    'type' => 'email'
                ),
//                'estado',
//                'fecha_creacion',
//                'fecha_actualizacion',
//                'usuario_creacion_id',
//                'usuario_actualizacion_id',
//                'cliente_estado_id',
//                'aprobado',
                'sucursal_id',
                'direccion_domicilio_id',
                'direccion_negocio_id',
                'descripcion',
//                'tipo',
            ),
        ));
        ?>
        <?php echo Chtml::link('<i class="icon-edit-sign"></i> Actualizar', array('update', 'id' => $model->id), array('class' => 'btn')) ?>
        <?php echo Chtml::link('<i class="icon-tasks"></i> Gestionar Etapa', array('update', 'id' => $model->id), array('class' => 'btn')) ?>
    </div>
</div>