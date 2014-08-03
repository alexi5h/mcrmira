<?php
/** @var PagoMesController $this */
/** @var PagoMes $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'pago-mes-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-plus"></i><?php echo Yii::t('AweCrud.app', $model->isNewRecord ? 'Create' : 'Update') . ' ' . PagoMes::label(1); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">


        <?php echo $form->textFieldRow($model, 'id') ?>

        <?php echo $form->textFieldRow($model, 'descripcion', array('maxlength' => 100)) ?>

        <?php
        echo $form->textFieldRow($model, 'cliente_id')
//        $model_cliente = Persona::model()->findAll();
//        echo $form->select2Row($model, 'cliente_id', array(
//            'asDropDownList' => true,
//            'data' => CHtml::listData($model_cliente, 'id', 'apelido_paterno'.'apellido_materno'.'primer_nombre'.'segundo_nombre'),
//            'options' => array(
//                'placeholder' => '-- Seleccione --',
//            )
//        ));
        ?>

        <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 5)) ?>

        <?php
        echo $form->datepickerRow(
                $model, 'fecha', array(
            'options' => array(
                'language' => 'es',
            )
                )
        );
        ?>

        <!--echo $form->dropDownListRow($model, 'estado', array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',))-->
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
