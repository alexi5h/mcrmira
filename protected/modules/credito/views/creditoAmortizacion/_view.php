<?php
/** @var CreditoAmortizacionController $this */
/** @var CreditoAmortizacion $data */
?>
<div class="view">
                    
        <?php if (!empty($data->nro_cuota)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('nro_cuota')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->nro_cuota); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_pago)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_pago')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_pago, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_pago)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->cuota)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cuota')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cuota); ?>
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
                
        <?php if (!empty($data->mora)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('mora')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->mora); ?>
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
                
        <?php if (!empty($data->credito->socio_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('credito_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->credito->socio_id); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>