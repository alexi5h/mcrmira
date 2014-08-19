<?php
/** @var AhorroController $this */
/** @var Ahorro $data */
?>
<div class="view">
                    
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
                
        <?php if (!empty($data->fecha)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha)); ?>
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
                
        <?php if (!empty($data->saldo_contra)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('saldo_contra')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->saldo_contra); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->saldo_favor)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('saldo_favor')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->saldo_favor); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->saldo_extra)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('saldo_extra')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->saldo_extra); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('anulado')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->anulado == 1 ? 'True' : 'False'); ?>
                            </div>
        </div>

    </div>