<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
Util::tsRegisterAssetJs('_decision_modal.js');
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-question"></i> ¿Qué desea hacer con la cantidad sobrante de dinero?</h4>
</div>
<div class="modal-body">
    <div class="row-fluid">
        <div class="span12">
            <h4>Cantidad: $<?php echo number_format($modelVol->cantidad, 2) ?></h4>
        </div>
        <!------- FORM AHORRO VOLUNTARIO ------->
        <?php
        /** @var AhorroController $this */
        /** @var Ahorro $model */
        /** @var AweActiveForm $form */
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'type' => 'horizontal',
            'id' => 'ahorroVoluntario-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="hidden">
            <?php echo $form->textFieldRow($modelVol, 'cantidad', array('maxlength' => 10, 'value' => $modelVol->cantidad)) ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success',
        'icon' => 'icon-dollar',
        'label' => 'Nuevo Ahorro Extra',
        'htmlOptions' => array(
            'onclick' => 'AjaxGuardarTipoExtra()',
        ),
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'success',
        'icon' => 'icon-dollar',
        'label' => 'Nuevo Ahorro Voluntario',
        'htmlOptions' => array(
            'onclick' => 'AjaxActualizacionInformacion("#ahorroVoluntario-form")',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>