<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Nro. créditos sin pagar',
            'value' => Credito::model()->de_socio($model->id)->en_deuda()->count(),
            'type' => 'raw',
        ),
        array(
            'name' => 'sucursal_id',
            'value' => $model->sucursal,
            'type' => 'raw',
        ),
        array(
            'name' => 'fecha_creacion',
            'value' => Util::FormatDate($model->fecha_creacion, 'd/m/Y'),
            'type' => 'raw',
        ),
        'estado_civil',
        array(
            'name' => 'actividad_economica_id',
            'value' => $model->actividad_economica,
            'type' => 'raw',
        ),
    ),
));
