<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;

Util::tsRegisterAssetJs('_form_modal.js');
?>
<div class="modal-header">


    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i> Registrar Ahorro Voluntario</h4>
</div>
<div class="modal-body">
    <div class="row-fluid">
        <?php
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'type' => 'horizontal',
            'id' => 'ahorro-deposito-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="span6">
            <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>
            <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>
            <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)) ?>
            <?php
            echo $form->datepickerRow(
                    $model, 'fecha_comprobante_entidad', array(
                'options' => array(
                    'language' => 'es',
                    'readonly' => 'readonly',
                ),
                    )
            );
            ?>
        </div>
        <div class="span6">



            <?php echo $form->dropDownListRow($model, 'sucursal_comprobante_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Sucursal::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>

            <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)) ?>
            <?php
            echo $form->datepickerRow(
                    $model, 'fecha_comprobante_su', array(
                'options' => array(
                    'language' => 'es',
                    'readonly' => 'readonly',
                ),
                    )
            );
            ?>
            <?php echo $form->textAreaRow($model,'observaciones') ?>
        </div>

        <?php $this->endWidget(); ?>


    </div>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success',
        'icon' => 'ok',
        'label' => Yii::t('AweCrud.app', 'Save'),
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


