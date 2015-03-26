<?php
/** @var AhorroRetiroController $this */
/** @var AhorroRetiro $model */
/** @var AweActiveForm $form */
Util::tsRegisterAssetJs('_form.js');


$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-retiro-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>

<div class="row-fluid">
    <div class="span6">
        <div class="widget blue ">
            <div class="widget-title">
                <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . AhorroRetiro::label(1); ?></h4>
                <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                    <!--a href="javascript:;" class="icon-remove"></a-->
                </span>
            </div>
            <div class="widget-body">





                <?php
                $model_persona = Persona::model()->activos()->findAll();
                echo $form->select2Row($model, 'socio_id', array(
                    'asDropDownList' => true,
                    'data' => CHtml::listData($model_persona, 'id', 'cedula_nombre_formato'),
                    'options' => array(
                        'placeholder' => '-- Seleccione --',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span12'
                    )
                ));
                ?>
<!--                --><?php //echo $form->dropDownListRow($model, 'sucursal_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Sucursal::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>

                <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'class' => 'money', 'readonly' => isset($_GET['socio_id']) ? 'readonly' : false,)) ?>

                <?php
                echo $form->datepickerRow(
                        $model, 'fecha_retiro', array(
                    'options' => array(
                        'language' => 'es',
                        'format' => 'dd/mm/yyyy',
                        'startView' => 2,
                        'orientation' => 'bottom right',
                    ),
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                    )
                        )
                );
                ?>

                <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>

                <?php // echo $form->textFieldRow($model, 'usuario_creacion_id') ?>

                <?php echo $form->textFieldRow($model, 'numero_cheque', array('maxlength' => 45)) ?>
            </div>                <div class="form-actions">
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
        <?php $this->endWidget(); ?>
    </div>
    <div class="span6">
        <div class="widget bluesky">
            <div class="widget-title">
                <h4><i class="icon-info-sign"></i> Informaci&oacute;n de Socio</h4>
                <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                </span>
            </div>
            <div class="widget-body" id="infoSocio">
                <?php
                if (isset($_GET['socio_id'])) {
                    $socio = Persona::model()->findByPk($_GET['socio_id']);
                    echo $this->renderPartial('_infoSocio', array('model' => $socio));
                } else {
                    ?>
                    <div class="alert alert-block alert-info">
                        <h4 class="alert-heading text-center">No se ha seleccionado un socio!</h4>
    <!--                        <p>
                            Best check yo self, you're not looking too good. Nulla vitae elit libero, a pharetra augue. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
                        </p>-->
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

