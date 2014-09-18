<?php
/** @var AhorroExtraController $this */
/** @var AhorroExtra $data */
?>
<div class="view">
                    
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
                
        <?php if (!empty($data->anulado)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('anulado')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->anulado); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->ahorro->descripcion)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('ahorro_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->ahorro->descripcion); ?>
            </div>
        </div>

        <?php endif; ?>
                
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
    </div>