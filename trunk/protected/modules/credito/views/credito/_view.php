<?php
/** @var CreditoController $this */
/** @var Credito $data */
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
                
        <?php if (!empty($data->garante_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('garante_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->garante_id); ?>
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
                
        <?php if (!empty($data->fecha_credito)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_credito')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_credito, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_credito)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_limite)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_limite')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_limite, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_limite)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->cantidad_total)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cantidad_total')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cantidad_total); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->interes)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('interes')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->interes); ?>
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
    </div>