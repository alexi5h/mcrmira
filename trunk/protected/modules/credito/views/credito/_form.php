<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerScriptFile($baseUrl . '/plugins/bootstraptoogle/js/bootstrap2-toggle.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstraptoogle/css/bootstrap2-toggle.min.css');
$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');

Util::tsRegisterAssetJs('_form.js');
/** @var CreditoController $this */
/** @var Credito $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'credito-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . Credito::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <?php
        $model_persona = Persona::model()->condicion_socio_credito();
        $model_garante = Persona::model()->condicion_garante_credito($model->id);
        ?>

        <div class="row-fluid">
            <div class="span6">
                <div class="control-group required">
                    <label class="control-label" for="Credito_socio_id">Socio <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'socio_id', $htmlOptions);
                        echo $form->error($model,'socio_id');
                        ?>
                        <span class="help-inline error" id="Credito_socio_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group required">
                    <label class="control-label" for="Credito_garante_id">Garante <span class="required">*</span></label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'garante_id', $htmlOptions);
                        echo $form->error($model,'garante_id');
                        ?>
                        <span class="help-inline error" id="Credito_garante_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
        </div>

        <?php
//        echo $form->select2Row($model, 'socio_id', array(
//            'asDropDownList' => true,
//            'data' => CHtml::listData($model_persona, 'id', 'cedula_nombre_formato'),
//            'options' => array(
//                'placeholder' => '-- Seleccione --',
//            )
//        ));
        ?>

        <?php
//        echo $form->select2Row($model, 'garante_id', array(
//            'asDropDownList' => true,
//            'data' => null,
//            'options' => array(
//                'placeholder' => '-- Seleccione --',
//            ),
//            'htmlOptions' => array(
//                'disabled' => true
//            ),
//        ));
        ?>

        <?php
        echo $form->datepickerRow(
                $model, 'fecha_credito', array(
            'options' => array(
                'language' => 'es',
                'readonly' => 'readonly',
                'format' => 'dd/mm/yyyy',
            ),
                )
        );
        ?>

        <?php // echo $form->dropDownListRow($model, 'cantidad_total', array('300' => 300, '700' => 700, '1200' => 1200, '3600' => 3600), array('placeholder' => null)) ?>

        <?php echo $form->textFieldRow($model, 'cantidad_total', array('maxlength' => 10)) ?>
        <?php echo $form->textFieldRow($model, 'periodos', array('maxlength' => 3)) ?>
        <?php echo $form->textFieldRow($model, 'numero_cheque', array('maxlength' => 45)) ?>

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
