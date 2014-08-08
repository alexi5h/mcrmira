<?php
/** @var DepositoController $this */
/** @var Deposito $model */
/** @var AweActiveForm $form */
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Util::tsRegisterAssetJs('_form_modal_deposito.js');
Yii::import('ext.CJuiDateTimePicker.CJuiDateTimePicker');

$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'deposito-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i> <?php echo ($model->isNewRecord ? 'Nuevo' : 'Update') . ' ' . Deposito::label(1); ?></h4>
</div>
<div class="modal-body">
    <center>    
        <?php
        $this->widget('ext.bootstrap.widgets.TbToggleButton', array(
            'name' => 'allClient_toggle',
            'disabledLabel' => 'Depositos',
            'enabledLabel' => 'Nuevo',
            'width' => 200,
            'value' => true,
            'enabledStyle' => 'warning',
            'disabledStyle' => 'primary',
            'onChange' => 'js:function($el, status, e){ alert(e);activarVistas(status); }'
                )
        );
        ?>
    </center>
    <div id="depositos-pago" class="hidden">
        <div class="widget blue">
            <div class="widget-title">
                <h4> <i class="icon-dollar"></i> Depositos </h4>        
            </div>
            <div class="widget-body">
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
                    /* array(
                      'name' => 'pago_mes_id',
                      'value' => 'isset($data->pagoMes) ? $data->pagoMes : null',
                      'filter' => CHtml::listData(PagoMes::model()->findAll(), 'id', PagoMes::representingColumn()),
                      ),
                     */
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div id="nuevo-deposito">
        <div class="widget blue">
            <div class="widget-title">
                <h4> <i class="icon-dollar"></i> Depositos </h4>        
            </div>
            <div class="widget-body">
                <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 45)) ?>

                <?php // echo $form->textFieldRow($model, 'entidad_bancaria_id') ?>
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
                echo $form->datepickerRow(
                        $model, 'fecha_comprobante_su', array(
                    'options' => array(
                        'language' => 'es',
                    )
                        )
                );
                ?>

                <?php
//    $pago = Pago::model()->findAll();
//
//    if (!empty($pago)) {
//        $pago = array(null => '-- Seleccione --') + CHtml::listData($pago, 'id', 'fecha');
//    } else {
//        $pago = array(null => '-- Ninguno --');
//    }
                ?>

                <?php //echo $form->dropDownListRow($model, 'pago_mes_id', array('' => ' -- Seleccione -- ') + CHtml::listData(PagoMes::model()->findAll(), 'id', PagoMes::representingColumn()))     ?>
                <?php // echo $form->dropDownListRow($model, 'pago_id', $pago, array('class' => 'span3'))  ?>


            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
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
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'icon' => 'remove',
        'label' => Yii::t('AweCrud.app', 'Cancel'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>


</div>

<?php $this->endWidget(); ?>
