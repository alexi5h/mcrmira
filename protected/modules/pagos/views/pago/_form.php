<?php
/** @var PagoController $this */
/** @var Pago $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'pago-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Pago::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">


        <?php //echo $form->textFieldRow($model, 'id') ?>

        

        <?php
        $model_cliente = Persona::model()->activos()->findAll();
        echo $form->select2Row($model, 'cliente_id', array(
            'asDropDownList' => true,
            'data' => CHtml::listData($model_cliente, 'id', 'nombre_formato'),
            'options' => array(
                'placeholder' => '-- Seleccione --',
            )
        ));
        ?>

        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 5)) ?>

        <?php
        if (!$model->isNewRecord)
            echo $form->datepickerRow(
                    $model, 'fecha', array(
                'options' => array(
                    'language' => 'es',
                )
                    )
            );
        ?>

        <?php
        if (!$model->isNewRecord)
            echo $form->dropDownListRow($model, 'estado', array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO'));
        ?>

        <?php echo $form->dropDownListRow($model, 'tipo', array('AHORRO' => 'AHORRO', 'PRIMER_PAGO' => 'PRIMER PAGO')) ?>

        <?php echo $form->textFieldRow($model, 'descripcion', array('maxlength' => 100)) ?>
        
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
