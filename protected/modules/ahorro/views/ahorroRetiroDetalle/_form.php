<?php
/** @var AhorroRetiroDetalleController $this */
/** @var AhorroRetiroDetalle $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-retiro-detalle-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . AhorroRetiroDetalle::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">



        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'class' => 'money')) ?>

        <?php echo $form->textFieldRow($model, 'ahorro_id') ?>

        <?php echo $form->dropDownListRow($model, 'ahorro_retiro_id', array('' => ' -- Seleccione -- ') + CHtml::listData(AhorroRetiro::model()->findAll(), 'id', AhorroRetiro::representingColumn())) ?>
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
