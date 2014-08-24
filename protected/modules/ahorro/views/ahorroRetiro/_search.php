<?php
/** @var AhorroRetiroController $this */
/** @var AweActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'type'=>'horizontal',
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
)); ?>
                <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'id'); ?>
                                <?php echo $form->textFieldRow($model, 'socio_id'); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'sucursal_id'); ?>
                                <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'fecha_retiro'); ?>
                                <?php echo $form->textFieldRow($model, 'comprobante_retiro', array('maxlength' => 45)); ?>
        </div>
                        <div class="span-12 ">
            <?php echo $form->textFieldRow($model, 'entidad_bancaria_id'); ?>
            </div><div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'type' => 'primary',
			'label' => Yii::t('AweCrud.app', 'Search'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
