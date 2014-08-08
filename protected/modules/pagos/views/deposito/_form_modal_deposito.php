<?php
/** @var DepositoController $this */
/** @var Deposito $model */
/** @var AweActiveForm $form */
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;

Util::tsRegisterAssetJs('_form_modal_deposito.js');
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i> <?php echo ($model->isNewRecord ? 'Nuevo' : 'Update') . ' ' . Deposito::label(1); ?></h4>
</div>
<div class="modal-body">
    <div class="row-fluid">
        <div class="span6">
            <?php
            $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
                'type' => 'horizontal',
                'id' => 'deposito-form',
                'enableAjaxValidation' => true,
                'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
                'enableClientValidation' => false,
            ));
            ;
            ?>

            <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 45)) ?>

            <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->findAll(), 'id', EntidadBancaria::representingColumn())) ?>

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

            <?php echo $form->textFieldRow($model, 'sucursal_comprobante_id') ?>

            <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)) ?>
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'type' => 'success',
                'icon' => 'ok',
                'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
                'htmlOptions' => array(
                    'onClick' => 'AjaxAtualizacionInformacion("#deposito-form")'
                ),
            ));
            ?>
            <?php $this->endWidget(); ?>

        </div>
        <div class="span6">
            <?php
            $depositos = new Deposito('search');
            $this->widget('ext.bootstrap.widgets.TbGridView', array(
                'id' => 'deposito-grid',
                'type' => '',
                "template" => "{items}{pager}",
                'dataProvider' => $depositos->searchByPago($model->pago_id),
                'columns' => array(
                    'cantidad',
                    'entidad_bancaria_id',
//                    'cod_comprobante_entidad',
//                    'fecha_comprobante_entidad',
//                    'sucursal_comprobante_id',
//                    'cod_comprobante_su',
                    'fecha_comprobante_su',
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'icon' => 'remove',
        'label' => Yii::t('AweCrud.app', 'Cerrar'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>


</div>

