<?php
/** @var AhorroRetiroDetalleController $this */
/** @var AhorroRetiroDetalle $data */
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
                
        <?php if (!empty($data->ahorro_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('ahorro_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->ahorro_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->ahorroRetiro->socio_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('ahorro_retiro_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->ahorroRetiro->socio_id); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>