<?php
Util::tsRegisterAssetJs('_form.js');
/** @var BarrioController $this */
/** @var Barrio $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'barrio-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Barrio::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 45)) ?>

        <?php
        if ($model->isNewRecord) {
            $model_provincia = Provincia::model()->findAll();
            $model_canton = new Canton;
            $model_parroquia = new Parroquia;
        } else {
            $model->provincia_id = $model->parroquia->canton->provincia->id;
            $model->canton_id = $model->parroquia->canton->id;
            $model_provincia = Provincia::model()->findAll();
            $model_canton = Canton::model()->findAll(array(
                "condition" => "provincia_id =:provincia_id ",
                "order" => "nombre",
                "params" => array(':provincia_id' => $model->parroquia->canton->provincia->id,)
            ));
            $model_parroquia = Parroquia::model()->findAll(
                    array(
                        "condition" => "canton_id =:canton_id",
                        "order" => "nombre",
                        "params" => array(':canton_id' => $model->parroquia->canton->id,)
            ));
        }

        echo $form->select2Row($model, 'provincia_id', array(
            'asDropDownList' => true,
            'data' => CHtml::listData($model_provincia, 'id', 'nombre'),
            'options' => array(
                'placeholder' => '-- Seleccione --',
            )
        ));
        ?>
        <?php
        echo $form->select2Row($model, 'canton_id', array(
            'asDropDownList' => true,
            'data' => CHtml::listData($model_canton, 'id', 'nombre'),
            'options' => array(
                'placeholder' => '-- Selecione Provincia --',
            )
        ));
        ?>
        <?php
        echo $form->select2Row($model, 'parroquia_id', array(
            'asDropDownList' => true,
            'data' => CHtml::listData($model_parroquia, 'id', 'nombre'),
            'options' => array(
                'placeholder' => '-- Selecione Cantón --',
            )
        ));
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
