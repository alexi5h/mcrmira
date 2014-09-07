<?php
/** @var CreditoController $this */
/** @var Credito $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
'type' => 'horizontal',
'id' => 'credito-form',
'enableAjaxValidation' => true,
'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
'enableClientValidation' => false,
));?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app',$model->isNewRecord ? 'Create' : 'Update') . ' ' . Credito::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        
        
            
                                        <?php echo $form->textFieldRow($model, 'socio_id') ?>
                                
                                        <?php echo $form->textFieldRow($model, 'garante_id') ?>
                                
                                        <?php echo $form->textFieldRow($model, 'sucursal_id') ?>
                                
                                        <?php echo $form->textFieldRow($model, 'fecha_credito') ?>
                                
                                        <?php echo $form->textFieldRow($model, 'fecha_limite') ?>
                                
                                        <?php echo $form->textFieldRow($model, 'cantidad_total', array('maxlength' => 10)) ?>
                                
                                        <?php echo $form->textFieldRow($model, 'interes', array('maxlength' => 3)) ?>
                                
                                        <?php echo $form->dropDownListRow($model, 'estado', array('DEUDA' => 'DEUDA','PAGADO' => 'PAGADO',)) ?>
                                                        <div class="form-actions">
                        <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'success',
			'label'=>$model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
		)); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
			'label'=> Yii::t('AweCrud.app', 'Cancel'),
			'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
		)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
