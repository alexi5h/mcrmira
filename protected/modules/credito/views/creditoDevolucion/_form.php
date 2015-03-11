<?php
/** @var CreditoDevolucionController $this */
/** @var CreditoDevolucion $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'credito-devolucion-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . CreditoDevolucion::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">



        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>

        <?php echo $form->dropDownListRow($model, 'estado', array('NO DEVUELTO' => 'NO DEVUELTO', 'DEVUELTO' => 'DEVUELTO',)) ?>

        <?php echo $form->textFieldRow($model, 'usuario_devolucion_id') ?>

        <?php echo $form->textFieldRow($model, 'fecha_devolucion') ?>

        <?php echo $form->dropDownListRow($model, 'credito_deposito_id', array('' => ' -- Seleccione -- ') + CHtml::listData(CreditoDeposito::model()->findAll(), 'id', CreditoDeposito::representingColumn())) ?>
    </div>                <div class="form-actions">
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
