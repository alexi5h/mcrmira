<?php
/** @var CantonController $this */
/** @var Canton $data */
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
                
        <?php if (!empty($data->provincia_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('provincia_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->provincia_id); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>