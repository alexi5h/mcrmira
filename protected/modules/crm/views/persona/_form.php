<?php
/** @var PersonaController $this */
/** @var Persona $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'persona-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Persona::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php echo $form->textFieldRow($model, 'primer_nombre', array('maxlength' => 20)) ?>

        <?php echo $form->textFieldRow($model, 'segundo_nombre', array('maxlength' => 20)) ?>

        <?php echo $form->textFieldRow($model, 'apellido_paterno', array('maxlength' => 30)) ?>

        <?php echo $form->textFieldRow($model, 'apellido_materno', array('maxlength' => 30)) ?>

        <?php echo $form->textFieldRow($model, 'cedula', array('maxlength' => 20)) ?>

        <?php echo $form->textFieldRow($model, 'telefono', array('maxlength' => 24)) ?>

        <?php echo $form->textFieldRow($model, 'celular', array('maxlength' => 24)) ?>

        <?php echo $form->textFieldRow($model, 'email', array('maxlength' => 255)) ?>

        <?php echo $form->textAreaRow($model, 'descripcion', array('rows' => 3, 'cols' => 50)) ?>

        <?php echo $form->dropDownListRow($model, 'estado', array('ACTIVO' => 'ACTIVO', 'INACTIVO' => 'INACTIVO',)) ?>

        <?php echo $form->textFieldRow($model, 'usuario_creacion_id') ?>

        <?php echo $form->textFieldRow($model, 'usuario_actualizacion_id') ?>

        <?php echo $form->textFieldRow($model, 'cliente_estado_id') ?>

        <?php echo $form->textFieldRow($model, 'aprobado') ?>

        <?php echo $form->textFieldRow($model, 'sucursal_id') ?>

        <?php echo $form->textFieldRow($model, 'direccion_domicilio_id') ?>

        <?php echo $form->textFieldRow($model, 'direccion_negocio_id') ?>

        <?php echo $form->textFieldRow($model, 'ruc', array('maxlength' => 13)) ?>

        <?php echo $form->dropDownListRow($model, 'tipo', array('CLIENTE' => 'CLIENTE', 'GARANTE' => 'GARANTE',)) ?>
    </div>              
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
