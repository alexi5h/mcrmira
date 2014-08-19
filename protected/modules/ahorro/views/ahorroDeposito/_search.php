<?php
/** @var AhorroDepositoController $this */
/** @var AweActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type'=>'horizontal',
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>
                <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'id'); ?>
                                <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'entidad_bancaria_id'); ?>
                                <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'fecha_comprobante_entidad'); ?>
                                <?php echo $form->textFieldRow($model, 'sucursal_comprobante_id'); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)); ?>
                                <?php echo $form->textFieldRow($model, 'fecha_comprobante_su'); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->dropDownListRow($model, 'pago_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn())); ?>
            </div><div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'type' => 'primary',
			'label' => Yii::t('AweCrud.app', 'Search'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
