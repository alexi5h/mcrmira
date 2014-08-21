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
                'id' => 'ahorro-deposito-form',
                'enableAjaxValidation' => true,
                'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
                'enableClientValidation' => false,
            ));
            ;
            ?>

            <div class="span12 ">
                <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>

                <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>
            </div>

            <div class="span12 ">
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

            <div class="span12 ">
                <?php // echo $form->textFieldRow($model, 'sucursal_comprobante_id') ?>
                <?php echo $form->dropDownListRow($model, 'sucursal_comprobante_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Sucursal::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>

                <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)) ?>
            </div>



            <!--<div class="span12 ">-->
                <?php // echo $form->textFieldRow($model, 'fecha_comprobante_su') ?>
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
                <?php // echo $form->dropDownListRow($model, 'pago_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn())) ?>
            <!--</div>-->

            <div id="buttondeposito">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type' => 'success',
                    'icon' => 'ok',
                    'label' => Yii::t('AweCrud.app', 'Save'),
                    'htmlOptions' => array(
                        'onClick' => 'AjaxAtualizacionInformacion("#ahorro-deposito-form")'
                    ),
                ));
                ?>
            </div>
            <?php $this->endWidget(); ?>

        </div>
        <div class="span6">
            <?php
            $depositos = new AhorroDeposito('search');
            $this->widget('ext.bootstrap.widgets.TbGridView', array(
                'id' => 'deposito-grid',
                'type' => '',
                "template" => "{items}{pager}",
                'dataProvider' => $depositos->searchByAhorro($model->pago_id),
                'columns' => array(
                    array(
                        'header' => 'Sucursal',
                        'name' => 'sucursal_comprobante_id',
                        'value' => '$data->sucursal_comprobante_id',
                        'type' => 'raw',
                    ),
                    array(
                        'header' => 'Cod. Comprobante',
                        'name' => 'cod_comprobante_su',
                        'value' => '$data->cod_comprobante_su',
                        'type' => 'raw',
                    ),
                    array(
                        'header' => 'Fecha',
                        'name' => 'fecha_comprobante_su',
                        'value' => '$data->fecha_comprobante_su',
                        'type' => 'raw',
                    ),
                    array(
                        'header' => 'Cantidad',
                        'name' => 'cantidad',
                        'value' => '$data->cantidad',
                        'type' => 'raw',
                    ),
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

