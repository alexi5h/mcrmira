<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;

Util::tsRegisterAssetJs('_form_modal.js');
?>
<?php
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorro-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => true,),
    'enableClientValidation' => false,
        ));
?>
<div class="modal-header">

    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i> Registrar Ahorro</h4>
</div>
<div class="modal-body">
    <?php echo $form->hiddenField($model,'socio_id');?>

    <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'class' => 'money')) ?>

    <?php
    echo $form->datepickerRow(
        $model, 'fecha', array(
            'options' => array(
                'language' => 'es',
                'format' => 'dd/mm/yyyy',
                'startView' => 2,
                'orientation' => 'bottom right',
            ),
            'htmlOptions' => array(
                'readonly' => 'readonly',
                'style'=>'cursor:pointer;'
            )
        )
    );
    ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success',
        'icon' => 'ok',
        'label' => Yii::t('AweCrud.app', 'Save'),
        'htmlOptions' => array(
            'onClick' => 'js:save("#ahorro-form")'
        ),
    ));
    ?>

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'icon' => 'remove',
        'label' => Yii::t('AweCrud.app', 'Cerrar'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
    <?php $this->endWidget(); ?>

</div>


