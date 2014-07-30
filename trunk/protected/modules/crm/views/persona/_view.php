<?php
/** @var PersonaController $this */
/** @var Persona $data */
?>
<div class="view">
                    
        <?php if (!empty($data->primer_nombre)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('primer_nombre')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->primer_nombre); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->segundo_nombre)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('segundo_nombre')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->segundo_nombre); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->apellido_paterno)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('apellido_paterno')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->apellido_paterno); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->apellido_materno)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('apellido_materno')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->apellido_materno); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->cedula)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cedula')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cedula); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->telefono)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('telefono')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->telefono); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->celular)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('celular')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->celular); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->email)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::mailto($data->email); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->descripcion)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->descripcion); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->estado)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->estado); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_creacion)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_creacion')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_creacion, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_creacion)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_actualizacion)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_actualizacion')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_actualizacion, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_actualizacion)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->usuario_creacion_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('usuario_creacion_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->usuario_creacion_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->usuario_actualizacion_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('usuario_actualizacion_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->usuario_actualizacion_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->cliente_estado_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cliente_estado_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cliente_estado_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->aprobado)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('aprobado')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->aprobado); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->sucursal_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('sucursal_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->sucursal_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->direccion_domicilio_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('direccion_domicilio_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->direccion_domicilio_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->direccion_negocio_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('direccion_negocio_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->direccion_negocio_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->ruc)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('ruc')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->ruc); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->tipo)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->tipo); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>