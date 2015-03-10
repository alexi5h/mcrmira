<?php
                $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
//        'nombre_formato',
//                array(
//                    'name' => 'tipo_identificacion',
//                    'value' => $model->getTipoIdentificacion()
//                ),
//        'cedula',
        'ruc',
        'telefono',
        'celular',
        array(
            'name' => 'email',
            'type' => 'email'
        ),
        array(
            'name' => 'sexo',
            'value' => $model->getGenero()
        ),
        array(
            'name' => 'fecha_nacimiento',
            'value' => Util::FormatDate($model->fecha_nacimiento, 'd-m-Y')
        ),
        'estado_civil',
        'discapacidad',
        'carga_familiar',
        array(
            'name' => 'actividad_economica_id',
            'value' => $model->actividad_economica,
            'type' => 'raw',
        ),
//                'estado',
//                'fecha_creacion',
//                'fecha_actualizacion',
//                'usuario_creacion_id',
//                'usuario_actualizacion_id',
//                'cliente_estado_id',
//                'aprobado',
        array(
            'name' => 'sucursal_id',
            'value' => $model->sucursal,
            'type' => 'raw',
        ),
        array(
            'name' => 'direccion_domicilio_id',
            'value' => $model->direccionDomicilio ? $model->direccionDomicilio->direccion_completa : null,
        ),
        array(
            'name' => 'direccion_negocio_id',
            'value' => $model->direccionNegocio ? $model->direccionNegocio->direccion_completa : null,
        ),
        'descripcion',
    ),
));
