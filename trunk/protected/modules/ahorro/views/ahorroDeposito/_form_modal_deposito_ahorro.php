<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Util::tsRegisterAssetJs('_form_modal_deposito_ahorro.js');


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
    $model_persona = Persona::model()->activos()->findAll();

    echo $form->select2Row($model, 'socio_id', array(
        'asDropDownList' => true,
        'data' => CHtml::listData($model_persona, 'id', 'cedula_nombre_formato'),
        'options' => array(
            'placeholder' => '-- Seleccione --',
        ),
        'htmlOptions' => array(
//            'class' => 'span6'
        )
    ));
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
            'readonly' => 'readonly',
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
            'onClick' => 'js:AjaxAtualizacionInformacion("#ahorro-deposito-form")'
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
