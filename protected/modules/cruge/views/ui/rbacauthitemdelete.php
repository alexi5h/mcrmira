<div class="widget red">
    <div class="widget-title">
        <h4><i class="icon-trash"></i> <?php echo ucwords(CrugeTranslator::t("eliminar"));?> <?php echo $model->name; ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body">
        <?php
            /* $model:  es una instancia que implementa a CrugeAuthItemEditor */
        ?>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'crugestoreduser-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
        )); ?>
        <p>
                <?php echo ucfirst(CrugeTranslator::t("marque la casilla para confirmar la eliminacion")); ?>
                <?php echo $form->checkBox($model,'deleteConfirmation'); ?>
                <?php echo $form->error($model,'deleteConfirmation'); ?>
        </p>

        <div class="form-actions">
            <div class="form-actions-float">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'danger',
                'icon'=>'ok',
                'label' => CrugeTranslator::t("Eliminar"),
            )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'id' => 'volver',
                'icon'=>'remove',
                'label' => Yii::t('AweCrud.app', 'Cancel'),
                'htmlOptions' => array('name' => 'volver')
            )); ?>
            </div>
        </div>
        <?php //echo $form->errorSummary($model); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>