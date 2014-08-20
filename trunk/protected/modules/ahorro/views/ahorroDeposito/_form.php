<div class="form">
    <?php
    /** @var AhorroDepositoController $this */
    /** @var AhorroDeposito $model */
    /** @var AweActiveForm $form */
    $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
        'type' => 'horizontal',
        'id' => 'ahorro-deposito-form',
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
        'enableClientValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model) ?>



    <div class="span12 ">
        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>

        <?php echo $form->textFieldRow($model, 'entidad_bancaria_id') ?>
    </div>

    <div class="span12 ">
        <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)) ?>

        <?php echo $form->textFieldRow($model, 'fecha_comprobante_entidad') ?>
    </div>

    <div class="span12 ">
        <?php echo $form->textFieldRow($model, 'sucursal_comprobante_id') ?>

        <?php echo $form->textFieldRow($model, 'cod_comprobante_su', array('maxlength' => 45)) ?>
    </div>

    <div class="span12 ">
        <?php echo $form->textFieldRow($model, 'fecha_comprobante_su') ?>

        <?php echo $form->dropDownListRow($model, 'pago_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn())) ?>
    </div>
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => Yii::t('AweCrud.app', 'Cancel'),
            'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
        ));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>