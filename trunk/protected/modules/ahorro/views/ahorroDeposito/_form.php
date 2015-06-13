<?php
/** @var AhorroDepositoController $this */
/** @var AhorroDeposito $model */
/** @var AweActiveForm $form */
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');
Util::tsRegisterAssetJs('_form.js');

$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-deposito-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
    'enableClientValidation' => false,
));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4>
            <i class="icon-plus"></i> Registrar Deposito
        </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">


        <div class="control-group ">
            <label class="control-label" for="AhorroDeposito_socio_id">Socio</label>

            <div class="controls">
                <?php
                $htmlOptions = array('class' => "span6");
                echo $form->hiddenField($model, 'socio_id', $htmlOptions);
                ?>
                <?php echo $form->error($model, 'socio_id'); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'class' => 'money')) ?>

        <?php echo $form->dropDownListRow($model, 'entidad_bancaria_id', array('' => ' -- Seleccione -- ') + CHtml::listData(EntidadBancaria::model()->activos()->findAll(), 'id', 'nombre'), array('placeholder' => '')) ?>

        <?php echo $form->textFieldRow($model, 'cod_comprobante_entidad', array('maxlength' => 45)) ?>



        <?php
        echo $form->datepickerRow(
            $model, 'fecha_comprobante_entidad', array(
                'options' => array(
                    'language' => 'es',
                    'format' => 'dd-mm-yyyy',
                    'endDate' => 'today',
                    'readonly' => 'readonly',
                ),
            )
        );
        ?>
        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'success',
                'label' => $model->isNewRecord?"Depositar":"Guardar",
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
