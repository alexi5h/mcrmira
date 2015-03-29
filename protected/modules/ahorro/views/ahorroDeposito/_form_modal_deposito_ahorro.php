<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Util::tsRegisterAssetJs('_form_modal_deposito_ahorro.js');
//var_dump($model);
//die();

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
    <h4><i class="icon-dollar"></i> <?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . AhorroDeposito::label(1); ?></h4>
</div>
<div class="modal-body">

    <?php
    echo $form->hiddenField($model, 'socio_id');
    echo $form->hiddenField($model, 'cod_comprobante_su');
    echo $form->hiddenField($model, 'sucursal_comprobante_id');
    ?>
    <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'class' => 'money')) ?>

    <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>


    <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)) ?>

    <?php
    echo $form->datepickerRow(
            $model, 'fecha_comprobante_entidad', array(
        'options' => array(
            'language' => 'es',
            'format' => 'dd-mm-yyyy',
            'endDate' => 'today',            
            'autoclose' => true,
        ),
            )
    );
    ?>


</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
//        'buttonType' => 'submit',
        'type' => 'success',
        'icon' => 'ok',
        'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
        'htmlOptions' => array(
            'onClick' => 'js:save("#ahorro-deposito-form")'
        ),
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'icon' => 'remove',
        'label' => Yii::t('AweCrud.app', 'Cerrar'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
