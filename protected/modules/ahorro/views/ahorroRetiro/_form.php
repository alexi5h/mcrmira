<?php
/** @var AhorroRetiroController $this */
/** @var AhorroRetiro $model */
/** @var AweActiveForm $form */
Util::tsRegisterAssetJs('_form.js');

$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-retiro-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . AhorroRetiro::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">





        <?php echo $form->dropDownListRow($model, 'socio_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Persona::model()->activos()->findAll(), 'id', 'nombre_formato'), array('placeholder' => '', 'class' => 'span4')) ?>
        <?php echo $form->dropDownListRow($model, 'sucursal_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Sucursal::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>

        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>



        <?php echo $form->radioButtonListRow($model, 'tipoAhorro', array(Ahorro::TIPO_OBLIGATORIO => Ahorro::TIPO_OBLIGATORIO, Ahorro::TIPO_VOLUNTARIO => Ahorro::TIPO_VOLUNTARIO), array('class' => 'hfgh')); ?>


        <?php echo $form->textFieldRow($model, 'fecha_retiro') ?>

        <?php echo $form->textFieldRow($model, 'comprobante_retiro', array('maxlength' => 45)) ?>


        <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>
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
