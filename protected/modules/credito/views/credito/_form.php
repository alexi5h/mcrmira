<?php
Util::tsRegisterAssetJs('_form.js');
/** @var CreditoController $this */
/** @var Credito $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'credito-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Credito::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <?php
        $model_persona = Persona::model()->condicion_socio_credito();
        $model_garante = Persona::model()->condicion_garante_credito($model->id);
        ?>
        <?php
        echo $form->select2Row($model, 'socio_id', array(
            'asDropDownList' => true,
            'data' => CHtml::listData($model_persona, 'id', 'cedula_nombre_formato'),
            'options' => array(
                'placeholder' => '-- Seleccione --',
            )
        ));
        ?>

        <?php
        echo $form->select2Row($model, 'garante_id', array(
            'asDropDownList' => true,
            'data' => null,
            'options' => array(
                'placeholder' => '-- Seleccione --',
            ),
            'htmlOptions'=>array(
                'disabled'=>true
            ),
        ));
        ?>

        <?php
        echo $form->datepickerRow(
                $model, 'fecha_credito', array(
            'options' => array(
                'language' => 'es',
                'readonly' => 'readonly',
                'format' => 'dd/mm/yyyy',
            ),
                )
        );
        ?>

        <?php // echo $form->dropDownListRow($model, 'cantidad_total', array('300' => 300, '700' => 700, '1200' => 1200, '3600' => 3600), array('placeholder' => null)) ?>

        <?php echo $form->textFieldRow($model, 'cantidad_total', array('maxlength' => 10)) ?>
        <?php echo $form->textFieldRow($model, 'periodos', array('maxlength' => 3)) ?>
        <?php echo $form->textFieldRow($model, 'numero_cheque', array('maxlength' => 45)) ?>

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
