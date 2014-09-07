<?php
/** @var CreditoAmortizacionController $this */
/** @var CreditoAmortizacion $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
'type' => 'horizontal',
'id' => 'credito-amortizacion-form',
'enableAjaxValidation' => true,
'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
'enableClientValidation' => false,
));?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app',$model->isNewRecord ? 'Create' : 'Update') . ' ' . CreditoAmortizacion::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        
        
            
                                        <?php echo $form->textFieldRow($model, 'nro_cuota') ?>
                                
                                        <?php echo $form->datepickerRow($model, 'fecha_pago', array('prepend' => '<i class="icon-calendar"></i>')) ?>
                                
                                        <?php echo $form->textFieldRow($model, 'cuota', array('maxlength' => 10)) ?>
                                
                                        <?php echo $form->textFieldRow($model, 'interes', array('maxlength' => 10)) ?>
                                
                                        <?php echo $form->textFieldRow($model, 'mora', array('maxlength' => 10)) ?>
                                
                                        <?php echo $form->dropDownListRow($model, 'estado', array('DEUDA' => 'DEUDA','PAGADO' => 'PAGADO',)) ?>
                                
                                        <?php echo $form->dropDownListRow($model, 'credito_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Credito::model()->findAll(), 'id', Credito::representingColumn())) ?>
                                        </div>                <div class="form-actions">
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
