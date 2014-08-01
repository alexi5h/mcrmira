<?php
/** @var SucursalController $this */
/** @var Sucursal $model */
/** @var AweActiveForm $form */
Util::tsRegisterAssetJs('_form.js');
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'sucursal-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
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

        <?php // die(var_dump($model)) ?>

        <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 45)) ?>

        <?php // echo $form->textFieldRow($model, 'direccion_id') ?>

        <div class="control-group" >
            <div class="control-group">
                <label class="control-label"><?php echo $form->labelEx($model, 'direccion_id') ?></label>
                <div class="controls">
                    <?php echo $form->textField($model->direccion, 'calle_1', array('maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Principal')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($model->direccion, 'calle_2', array('maxlength' => 128, 'class' => 'span10', 'placeholder' => 'Calle Secundaria')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textField($model->direccion, 'numero', array('maxlength' => 20, 'class' => 'span10', 'placeholder' => 'Número')) ?>  
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <div class="span4">
                        <?php
                        if ($model->isNewRecord) {
                            $model_provincia = Provincia::model()->findAll();
                            $model_canton = new Canton;
                            $model_parroquia = new Parroquia;
                            $model_barrio = new Barrio;
                        } else {
                            $model->provincia_id = $model->direccion->barrio->parroquia->canton->provincia->id;
                            $model->canton_id = $model->direccion->barrio->parroquia->canton->id;
                            $model_provincia = Provincia::model()->findAll();
                            $model_canton = Canton::model()->findAll(array(
                                "condition" => "provincia_id =:provincia_id ",
                                "order" => "nombre",
                                "params" => array(':provincia_id' => $model->direccion->barrio->parroquia->canton->provincia->id,)
                            ));
                            $model_parroquia = Parroquia::model()->findAll(
                                    array(
                                        "condition" => "canton_id =:canton_id",
                                        "order" => "nombre",
                                        "params" => array(':canton_id' => $model->direccion->barrio->parroquia->canton->id,)
                            ));
                            $model_barrio = Barrio::model()->findAll(
                                    array(
                                        "condition" => "parroquia_id =:parroquia_id",
                                        "order" => "nombre",
                                        "params" => array(':parroquia_id' => $model->direccion->barrio->parroquia->id,)
                            ));
                        }

//                    echo $form->select2Row($model, 'provincia_id', array(
//                        'asDropDownList' => true,
//                        'data' => CHtml::listData($model_provincia, 'id', 'nombre'),
//                        'options' => array(
//                            'placeholder' => '-- Seleccione Provincia --',
//                        )
//                    ));
//                        var_dump($model->provincia_id);
                        $lista_provincia = !$model->provincia_id ? array(0 => '- Provincia -') + CHtml::listData(Provincia::model()->findAll(), 'id', 'nombre') : array(0 => '- Provincia -') +
                                CHtml::listData(
                                        Provincia::model()->findAll(
                                        ), 'id', 'nombre');

                        $this->widget(
                                'bootstrap.widgets.TbSelect2', array(
                            'asDropDownList' => TRUE,
                            'name' => 'Sucursal[provincia_id]',
                            'model' => $model,
                            'data' => $lista_provincia,
                            'val' => $model->provincia_id ? $model->provincia_id : 0,
                            'options' => array(
                                'placeholder' => 'provincias',
                                'width' => '100%',
                            )
                                )
                        );
                        ?>
                    </div>
                    <div class="span4">
                        <?php
//                    echo $form->select2Row($model, 'canton_id', array(
//                        'asDropDownList' => true,
//                        'data' => CHtml::listData($model_canton, 'id', 'nombre'),
//                        'options' => array(
//                            'placeholder' => '-- Selecione Canton --',
//                        )
//                    ));

                        $lista_canton = !$model->canton_id ? array(0 => '- Ninguno -') : array(0 => '- canton -') + CHtml::listData(
                                        Canton::model()->findAll(array(
                                            "condition" => "provincia_id =:provincia_id ",
                                            "order" => "nombre",
                                            "params" => array(':provincia_id' => $model->direccion->barrio->parroquia->canton->provincia->id,)
                                        )), 'id', 'nombre');
                        $this->widget(
                                'bootstrap.widgets.TbSelect2', array(
                            'asDropDownList' => TRUE,
                            'name' => 'Sucursal[canton_id]',
                            'model' => $model,
                            'data' => $lista_canton,
                            'val' => $model->canton_id ? $model->canton_id : 0,
                            'options' => array(
                                'placeholder' => 'cantones',
                                'width' => '100%',
                            )
                                )
                        );
                        ?>

                        <?php // echo $form->textField($model->direccion, 'parroquia_id', array('maxlength' => 32, 'class' => 'span5', 'placeholder' => 'Parroquia')) ?>
                        <?php // echo $form->textField($model->direccion, 'barrio_id', array('maxlength' => 32, 'class' => 'span5', 'placeholder' => 'Barrio')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <div class="span4">
                        <?php
//                    echo $form->select2Row($model->direccion, 'parroquia_id', array(
//                        'asDropDownList' => true,
//                        'data' => CHtml::listData($model_parroquia, 'id', 'nombre'),
//                        'options' => array(
//                            'placeholder' => '-- Selecione Parroquia --',
//                        )
//                    ));


                        $lista_parroquia = !$model->direccion->parroquia_id ? array(0 => '- Ninguno -') : array(0 => '- Barrio -') + CHtml::listData(
                                        Parroquia::model()->findAll(
                                                array(
                                                    "condition" => "canton_id =:canton_id",
                                                    "order" => "nombre",
                                                    "params" => array(':canton_id' => $model->direccion->barrio->parroquia->canton->id,)
                                        )), 'id', 'nombre');
                        $this->widget(
                                'bootstrap.widgets.TbSelect2', array(
                            'asDropDownList' => TRUE,
                            'name' => 'Direccion[parroquia_id]',
                            'model' => $model->direccion,
                            'data' => $lista_parroquia,
                            'val' => $model->direccion->parroquia_id ? $model->direccion->parroquia_id : 0,
                            'options' => array(
                                'placeholder' => 'Barrios',
                                'width' => '100%',
                            )
                                )
                        );
                        ?>
                        <?php echo $form->error($model, 'parroquia_id'); ?>
                    </div>
                    <div class="span4">
                        <?php
//                    echo $form->select2Row($model->direccion, 'barrio_id', array(
//                        'asDropDownList' => true,
//                        'data' => CHtml::listData($model_barrio, 'id', 'nombre'),
//                        'options' => array(
//                            'placeholder' => '-- Selecione Barrio --',
//                        )
//                    ));

                        $lista_barrio = !$model->direccion->barrio_id ? array(0 => '- Ninguno -') : array(0 => '- Barrio -') + CHtml::listData(
                                        Barrio::model()->findAll(
                                                array(
                                                    "condition" => "parroquia_id =:parroquia_id",
                                                    "order" => "nombre",
                                                    "params" => array(':parroquia_id' => $model->direccion->barrio->parroquia->id,)
                                        )), 'id', 'nombre');
                        $this->widget(
                                'bootstrap.widgets.TbSelect2', array(
                            'asDropDownList' => TRUE,
                            'name' => 'Direccion[barrio_id]',
                            'model' => $model->direccion,
                            'data' => $lista_barrio,
                            'val' => $model->direccion->barrio_id ? $model->direccion->barrio_id : 0,
                            'options' => array(
                                'placeholder' => 'Barrios',
                                'width' => '100%',
                            )
                                )
                        );
                        ?>
                        <?php echo $form->error($model, 'barrio_id'); ?>
                    </div>
                </div>
            </div>
            <div class="control-group" >
                <div class="controls controls-row">
                    <?php echo $form->textArea($model->direccion, 'referencia', array('maxlength' => 16, 'class' => 'span8', 'placeholder' => 'Referencia')) ?>

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
