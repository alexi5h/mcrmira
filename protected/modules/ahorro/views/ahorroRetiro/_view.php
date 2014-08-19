<?php
/** @var AhorroRetiroController $this */
/** @var AhorroRetiro $data */
?>
<div class="view">
                    
        <?php if (!empty($data->socio_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('socio_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->socio_id); ?>
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
                
        <?php if (!empty($data->cantidad)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cantidad')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cantidad); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_retiro)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_retiro')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_retiro, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_retiro)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->comprobante_retiro)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('comprobante_retiro')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->comprobante_retiro); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->entidad_bancaria_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('entidad_bancaria_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->entidad_bancaria_id); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>