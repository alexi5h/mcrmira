<?php
/** @var EntradaController $this */
/** @var Entrada $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'importar-form',
    'enableAjaxValidation' => false,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>

<div class="row-fluid">

    <?php echo $form->fileFieldRow($model, 'csv_file') ?>

    <div class="control-group">
        <?php echo $form->labelEx($model, 'tipo_entidad', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'tipo_entidad', array(null => '-- Seleccione --', '1' => 'SOCIOS'), array('class' => 'span4',))
//        $this->widget(
//                'ext.bootstrap.widgets.TbToggleButton', array(
//            'model' => $model,
//            'disabledLabel' => 'CUENTA',
//            'enabledLabel' => 'CONTACTO',
//            'width' => 200,
//            'value' => true,
//            'enabledStyle' => 'warning',
//            'disabledStyle' => 'primary',
//            'name' => 'tipo_entidad',
//            'attribute' => 'tipo_entidad',
//            //  'htmlOptions' => array('tabindex' => "$cont"),
//            'onChange' => 'js:function($el, status, e){console.log(status)}'
//                )
//        );
            ?>

            <?php echo $form->error($model, 'tipo_entidad') ?> 

        </div>    
        <label ><strong>Nota : </strong> La Informaci&oacute;n puede ser de Cuenta o Contacto. </label>
    </div>
    <!--<label class="control-label required" for="tipo_entidad">¿Informac&iacute;on de? </label>-->



    <!--</div>-->


</div>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'icon' => 'ok',
        'type' => 'success',
        'label' => Yii::t('AweCrud.app', 'Cargar Archivo'),
    ));
    ?>
</div>



<div id="status"></div>

<?php $this->endWidget(); ?>