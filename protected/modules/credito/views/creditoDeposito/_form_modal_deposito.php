<?php
/** @var DepositoController $this */
/** @var Deposito $model */
/** @var AweActiveForm $form */
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
Util::tsRegisterAssetJs('_form_modal_deposito.js');
$credito=  Credito::model()->findByPk($model->credito_id);
?>

<div class="modal-header span12" style="margin: 0px">
    <a class="close" data-dismiss="modal">&times;</a>
    <!--<div class="span6">-->
    <h4 class="span6" style="margin: 10px 0px 0px 0px"><i class="icon-dollar"></i> <?php echo ($model->isNewRecord ? 'Nuevo' : 'Update') . ' ' . CreditoDeposito::label(1); ?></h4>
    <!--</div>-->
    <h4 class="span6" style="margin: 10px 0px 0px 0px"><i class="icon-money"></i> Detalle de Amortización</h4>

</div>
<div class="modal-body">
    <div class="row-fluid">
        <div class="span6" style="padding-top: 10px">
            <?php
            /** @var CreditoDepositoController $this */
            /** @var CreditoDeposito $model */
            /** @var AweActiveForm $form */
            $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
                'type' => 'horizontal',
                'id' => 'credito-deposito-form',
                'enableAjaxValidation' => true,
                'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
                'enableClientValidation' => false,
            ));
            ?>

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
            <?php // echo $form->dropDownListRow($model, 'sucursal_comprobante_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Sucursal::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>
            <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)) ?>
            <?php // echo $form->textFieldRow($model, 'fecha_comprobante_su') ?>
            <?php echo $form->textAreaRow($model, 'observaciones', array('rows' => 3, 'cols' => 50)) ?>

            <?php // echo $form->dropDownListRow($model, 'credito_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Credito::model()->findAll(), 'id', Credito::representingColumn())) ?>



        </div>
        <div class="span6">
            <?php
            $amortizaciones = CreditoAmortizacion::model()->de_credito($model->credito_id)->search();
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'credito-amortizacion-grid',
//                'type' => 'striped bordered hover advance',
                'template' => '{items}{summary}{pager}',
                'dataProvider' => $amortizaciones,
                'columns' => array(
//                    'nro_cuota',
                    array(
                        'header' => 'Nº',
                        'name' => 'nro_cuota',
                        'value' => '$data->nro_cuota',
                        'type' => 'raw',
                    ),
                    'fecha_pago',
                    'cuota',
                    'saldo_contra',
                    'saldo_favor',
//                    'interes',
//                    'mora',
                    array(
                        'name' => 'estado',
                        'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                    ),
                ),
                'htmlOptions' => array('style' => 'padding-top: 5px;'),
            ));
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="span4">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'type' => 'success',
            'icon' => 'ok',
            'label' => Yii::t('AweCrud.app', 'Save'),
            'htmlOptions' => array(
                'onClick' => 'AjaxActualizacionInformacion("#credito-deposito-form")',
                'style' => 'float: left;',
            ),
        ));
        ?>
        <?php $this->endWidget(); ?>
    </div>
    <div id="centrado" class="span4">
        <h4 style="margin: 5px 0px 0px 0px; text-align: center">$<?php echo $credito->saldo_contra ?> por pagar</h4>
    </div>
    <div class="span4">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'icon' => 'remove',
            'label' => Yii::t('AweCrud.app', 'Cerrar'),
            'htmlOptions' => array('data-dismiss' => 'modal'),
        ));
        ?>
    </div>
</div>