<?php
/** @var ParroquiaController $this */
/** @var Parroquia $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'vertical',
    'id' => 'parroquia-form',
    'action' => Yii::app()->baseUrl . '/crm/parroquia/create/popoup/1',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => false,
        ));
?>

<div class="widget-body">
    <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 32)) ?>
    <?php
    if ($model->isNewRecord) {
        $model_provincia = Provincia::model()->findAll();
        $model_canton = Canton::model()->findAll();
    }
//    else {
//        $model->provincia_id = $model->canton->provincia->id;
//        $model_provincia = Provincia::model()->findAll();
//        $model_canton = Canton::model()->findAll(array(
//            "condition" => "provincia_id =:provincia_id ",
//            "order" => "nombre",
//            "params" => array(':provincia_id' => $model->canton->provincia->id,)
//        ));
//    }

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
    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'type' => 'success',
            'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
            'htmlOptions' => array('onclick' => 'guardarParroquiaPopouver("#parroquia-form","#' . $buttomId . '","' . $control . '",' . $nro . ')')
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('AweCrud.app', 'Cerrar'),
            'htmlOptions' => array('onclick' => '$("#' . $buttomId . '").popover("hide")')
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>

