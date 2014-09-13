<?php
/** @var AhorroController $this */
/** @var Ahorro $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Registar' : 'Update') . ' ' . Ahorro::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">



        <?php echo $form->textFieldRow($model, 'descripcion', array('maxlength' => 50)) ?>

        <?php echo $form->textFieldRow($model, 'socio_id') ?>

        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>

        <?php
        echo $form->datepickerRow(
                $model, 'fecha', array(
            'options' => array(
                'language' => 'es',
                'format' => 'dd/mm/yyyy',
                'startView' => 2,
                'orientation' => 'bottom right',
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
            )
                )
        );
        ?>

        <?php //echo $form->dropDownListRow($model, 'estado', array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',)) ?>

        <?php echo $form->dropDownListRow($model, 'tipo', array('OBLIGATORIO' => 'OBLIGATORIO', 'VOLUNTARIO' => 'VOLUNTARIO', 'PRIMER_PAGO' => 'PRIMER_PAGO',)) ?>

        <?php //echo $form->textFieldRow($model, 'saldo_contra', array('maxlength' => 10)) ?>

        <?php //echo $form->textFieldRow($model, 'saldo_favor', array('maxlength' => 10)) ?>

        <?php //echo $form->textFieldRow($model, 'saldo_extra', array('maxlength' => 10)) ?>

        <?php // echo $form->dropDownListRow($model, 'anulado', array('SI'=>'SI','NO'=>'NO')) ?>
        
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
