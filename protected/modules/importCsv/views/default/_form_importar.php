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
                ?>

                <?php echo $form->error($model, 'tipo_entidad') ?>

            </div>

        </div>
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