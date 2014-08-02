<?php
/** @var SucursalController $this */
/** @var Sucursal $model */
/** @var AweActiveForm $form */
Util::tsRegisterAssetJs('_form.js');
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'sucursal-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,
        'afterValidate' => 'js:function(form, data, hasError){ $("#contenedor > div :not(.error)").addClass("success")}'
    ),
    'enableClientValidation' => false,
//    'htmlOptions' => array(
//        
//    )
        ));
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Sucursal::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php echo $form->errorSummary(array($model, $modelDireccion)) ?>
        <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 45)) ?>

        <?php // echo $form->textFieldRow($model, 'direccion_id')  ?>
        <div id="contenedor">
            <div class="control-group ">
                <label class="control-label"><?php echo $form->labelEx($model, 'direccion_id') ?></label>
                <div class="controls">
                    <?php echo $form->textField($modelDireccion, 'calle_1', array('maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Principal')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($modelDireccion, 'calle_2', array('maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Secundaria')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($modelDireccion, 'numero', array('maxlength' => 20, 'class' => 'span10', 'placeholder' => 'Número')) ?>  
                </div>
            </div>
            <div class="controls controls-row">
                <div class=" control-group span4">
                    <?php
                    $lista_provincia = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion[provincia_id]',
                        'model' => $modelDireccion,
                        'data' => $lista_provincia,
                        'val' => $modelDireccion->provincia_id,
                        'options' => array(
                            'placeholder' => '-- Provincia --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion, 'provincia_id'); ?>
                </div>
                <div class=" control-group span4">
                    <?php
                    $lista_canton = null;
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion[canton_id]',
                        'model' => $modelDireccion,
                        'data' => $lista_canton,
                        'val' => $modelDireccion->canton_id,
                        'options' => array(
                            'placeholder' => '-- Canton --',
                            'width' => '100%',
                        )
                            )
                    );
//                        
                    ?>
                    <?php echo $form->error($modelDireccion, 'canton_id'); ?>
                </div>
            </div>
            <div class="controls controls-row">
                <div class="control-group span4">
                    <?php
                    $lista_parroquia = null;
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion[parroquia_id]',
                        'model' => $modelDireccion,
                        'data' => $lista_parroquia,
                        'val' => $modelDireccion->parroquia_id,
                        'options' => array(
                            'placeholder' => '-- Parroquia --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion, 'parroquia_id'); ?>
                </div>
                <div class="control-group  success span4">
                    <?php
                    $lista_barrio = null;
                    $this->widget(
                            'bootstrap.widgets.TbSelect2', array(
                        'asDropDownList' => TRUE,
                        'name' => 'Direccion[barrio_id]',
                        'model' => $modelDireccion,
                        'data' => $lista_barrio,
                        'val' => $modelDireccion->barrio_id,
                        'options' => array(
                            'placeholder' => '-- Barrio --',
                            'width' => '100%',
                        )
                            )
                    );
                    ?>
                    <?php echo $form->error($modelDireccion, 'barrio_id'); ?>
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <div class="control-group span8">
                        <?php echo $form->textArea($modelDireccion, 'referencia', array('class' => 'span12', 'placeholder' => 'Referencia')) ?>

                    </div>
                </div>
            </div>
        </div>
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
