<?php
/** @var CantonController $this */
/** @var Canton $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'canton-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Canton::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">



        <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 45)) ?>
        <!--@TODO: borrar comentarios-->
        <?php // echo $form->textFieldRow($model, 'provincia_id') ?>
        <?php
        $model_provincia = Provincia::model()->findAll();
        if (!empty($model_provincia)) {
            echo $form->select2Row($model, 'provincia_id', array(
                'asDropDownList' => true,
                'data' => CHtml::listData($model_provincia, 'id', 'nombre'),
//                    'empty' => array(0 => '- Ninguna -'),
//                    'class' => 'span6',
                'options' => array(
                    'placeholder' => 'PROVINCIA',
                )
            ));
        }
        ?>
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
