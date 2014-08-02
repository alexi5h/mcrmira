<?php
/** @var EntidadBancariaController $this */
/** @var EntidadBancaria $model */
/** @var AweActiveForm $form */
Util::tsRegisterAssetJs('_form.js');
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'entidad-bancaria-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'afterValidate' => 'js:function(form, data, hasError){ $("#contenedor > div :not(.error)").addClass("success");return true;}'
    ),
    'enableClientValidation' => false,
        ));
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . EntidadBancaria::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">


        <?php echo $form->errorSummary(array($model, $modelDireccion)) ?>
        <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 45)) ?>

        <?php // echo $form->dropDownListRow($model, 'direccion_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Direccion::model()->findAll(), 'id', Direccion::representingColumn())) ?>

        <?php
        if ($model->isNewRecord) {
            $lista_provincia = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
            $lista_canton = null;
            $lista_parroquia = null;
            $lista_barrio = null;
        } else {
            $modelDireccion->provincia_id = $modelDireccion->parroquia->canton->provincia->id;
            $modelDireccion->canton_id = $modelDireccion->parroquia->canton->id;
            $lista_provincia = CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre');
            $lista_canton = CHtml::listData(Canton::model()->findAll(array(
                                "condition" => "provincia_id =:provincia_id ",
                                "order" => "nombre",
                                "params" => array(':provincia_id' => $modelDireccion->parroquia->canton->provincia->id,)
                            )), 'id', 'nombre');
            $lista_parroquia = CHtml::listData(Parroquia::model()->findAll(
                                    array(
                                        "condition" => "canton_id =:canton_id",
                                        "order" => "nombre",
                                        "params" => array(':canton_id' => $modelDireccion->parroquia->canton->id,)
                            )), 'id', 'nombre');
            $lista_barrio = null;
            if ($modelDireccion->parroquia_id) {
                $lista_barrio = CHtml::listData(Barrio::model()->findAll(
                                        array(
                                            "condition" => "parroquia_id =:parroquia_id",
                                            "order" => "nombre",
                                            "params" => array(':parroquia_id' => $modelDireccion->parroquia_id,)
                                )), 'id', 'nombre');
            }
        }
        ?>
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
</div>
<?php $this->endWidget(); ?>
