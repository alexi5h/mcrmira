<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
Util::tsRegisterAssetJs('_decision_modal.js');
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i>¿Qué desea hacer con la cantidad sobrante de dinero?</h4>
</div>
<div class="modal-body">
    <div class="row-fluid">
        <div class="span12">
            <h4>Cantidad: $<?php echo $model->cantidad ?></h4>
        </div>
        
        <!------- FORM AHORRO EXTRA ------->
        <?php
        /** @var AhorroExtraController $this */
        /** @var AhorroExtra $model */
        /** @var AweActiveForm $form */
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'type' => 'horizontal',
            'id' => 'ahorroExtra-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="hidden">
            <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'value' => $model->cantidad)) ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'success',
        'icon' => 'icon-dollar',
        'label' => 'Nuevo Ahorro Extra',
//        'url' => "ahorro/ahorroExtra/create?id_ahorro=".$model->ahorro_id,
        'htmlOptions' => array(
//            'href' => 'ahorro/ahorroExtra/create/ahorro_id/'.$model->ahorro_id.'/cantidad_extra/'.$model->cantidad,
            'onclick' => 'AjaxActualizacionInformacion("#ahorroExtra-form")',
        ),
//        'active' => '($data->estado=="PAGADO")?false:true',
    ));
    ?>
</div>
<?php $this->endWidget(); ?>


<!--<div class="modal-body">
    <div class="row-fluid">
        <div class="span12">
            <h4>Cantidad: $<?php // echo $model->cantidad ?></h4>
        </div>
        
        ----- FORM AHORRO EXTRA -----
        <?php
        /** @var AhorroExtraController $this */
        /** @var AhorroExtra $model */
        /** @var AweActiveForm $form */
        $form2 = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'type' => 'horizontal',
            'id' => 'ahorroExtra-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="hidden">
            <?php echo $form2->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'value' => $model->cantidad)) ?>
        </div>
    </div>
</div>-->
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'success',
        'icon' => 'icon-dollar',
        'label' => 'Nuevo Ahorro Voluntario',
//        'url' => "ahorro/ahorroExtra/create?id_ahorro=".$model->ahorro_id,
        'htmlOptions' => array(
//            'href' => 'ahorro/ahorroExtra/create/ahorro_id/'.$model->ahorro_id.'/cantidad_extra/'.$model->cantidad,
            'onclick' => 'AjaxActualizacionInformacion("#ahorroExtra-form")',
        ),
//        'active' => '($data->estado=="PAGADO")?false:true',
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
