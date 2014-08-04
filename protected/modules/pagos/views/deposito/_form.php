<?php
/** @var DepositoController $this */
/** @var Deposito $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'deposito-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Deposito::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">



        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 45)) ?>

        <?php echo $form->textFieldRow($model, 'entidad_bancaria_id') ?>

        <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)) ?>

        <?php
        echo $form->datepickerRow(
                $model, 'fecha_comprobante_entidad', array(
            'options' => array(
                'language' => 'es',
            )
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

            <?php //echo $form->dropDownListRow($model, 'pago_mes_id', array('' => ' -- Seleccione -- ') + CHtml::listData(PagoMes::model()->findAll(), 'id', PagoMes::representingColumn())) ?>
        <?php echo $form->dropDownListRow($model, 'pago_mes_id', array('' => ' -- Seleccione -- ') + CHtml::listData(PagoMes::model()->findAll(), 'id', PagoMes::representingColumn()), array('class' => 'span3')) ?>
        
        <div class="form-actions">
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
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
