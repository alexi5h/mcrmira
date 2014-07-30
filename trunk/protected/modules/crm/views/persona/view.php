<?php
/** @var PersonaController $this */
/** @var Persona $model */

$this->menu=array(
    //array('label' => Yii::t('AweCrud.app', 'List') . ' ' . Persona::label(2), 'icon' => 'list', 'url' => array('index')),
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
                  'primer_nombre',
             'segundo_nombre',
             'apellido_paterno',
             'apellido_materno',
             'cedula',
             'telefono',
             'celular',
             array(
                'name' => 'email',
                'type' => 'email'
            ),
             'descripcion',
             'estado',
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
             'tipo',
	),
)); ?>
</fieldset>