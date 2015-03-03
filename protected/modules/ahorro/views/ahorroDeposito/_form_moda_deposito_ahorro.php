<?php
/** @var AhorroDepositoController $this */
/** @var AhorroDeposito $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-deposito-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>

<div class="modal-header">

    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . AhorroDeposito::label(1); ?></h4>
</div>
<div class="modal-body">

    <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>

    <?php echo $form->textFieldRow($model, 'entidad_bancaria_id') ?>

    <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)) ?>

    <?php echo $form->textFieldRow($model, 'fecha_comprobante_entidad') ?>

    <?php echo $form->textFieldRow($model, 'sucursal_comprobante_id') ?>

    <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)) ?>

    <?php echo $form->textFieldRow($model, 'fecha_comprobante_su') ?>

    <?php echo $form->textFieldRow($model, 'usuario_creacion_id') ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'success',
        'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('AweCrud.app', 'Cancel'),
        'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
    ));
    ?>
    <?php $this->endWidget(); ?>
</div>
