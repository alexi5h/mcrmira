<?php
/** @var DepositoController $this */
/** @var Deposito $data */
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
                
        <?php if (!empty($data->cod_comprobante_entidad)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cod_comprobante_entidad')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cod_comprobante_entidad); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_comprobante_entidad)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_comprobante_entidad')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_comprobante_entidad, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_comprobante_entidad)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->sucursal_comprobante_id)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('sucursal_comprobante_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->sucursal_comprobante_id); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->cod_comprobante_su)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('cod_comprobante_su')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->cod_comprobante_su); ?>
            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->fecha_comprobante_su)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('fecha_comprobante_su')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->fecha_comprobante_su, 'medium', 'medium'); ?>
            <br/>
                 <?php echo date('D, d M y H:i:s', strtotime($data->fecha_comprobante_su)); ?>
                            </div>
        </div>

        <?php endif; ?>
                
        <?php if (!empty($data->pagoMes->descripcion)): ?>
        <div class="field">
            <div class="field_name">
                <b><?php echo CHtml::encode($data->getAttributeLabel('pago_mes_id')); ?>:</b>
            </div>
            <div class="field_value">
                <?php echo CHtml::encode($data->pagoMes->descripcion); ?>
            </div>
        </div>

        <?php endif; ?>
    </div>