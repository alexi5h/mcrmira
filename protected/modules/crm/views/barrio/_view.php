<?php
/** @var BarrioController $this */
/** @var Barrio $data */
?>
<div class="view">
                    
        <?php if (!empty($data->nombre)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->nombre); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->parroquia_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('parroquia_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->parroquia_id); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>