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
            'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="hidden">
            <?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10, 'value' => $model->cantidad)) ?>
            <?php // echo $form->dropDownListRow($model, 'anulado', array('SI' => 'SI', 'NO' => 'NO',),array('value'=>'NO')) ?>
            <?php // echo $form->dropDownListRow($model, 'ahorro_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn())) ?>
            <div class="form-actions">
                <?php
//        $this->widget('bootstrap.widgets.TbButton', array(
//            'buttonType' => 'submit',
//            'type' => 'success',
//            'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
//        ));
                ?>
                <?php
//        $this->widget('bootstrap.widgets.TbButton', array(
//            'label' => Yii::t('AweCrud.app', 'Cancel'),
//            'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
//        ));
                ?>
            </div>
        </div>




    </div>
</div>
<div class="modal-footer">
    <?php
//    $this->widget('bootstrap.widgets.TbButton', array(
//        'buttonType' => 'submit',
////        'icon' => 'ok',
//        'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i> Nuevo Ahorro Voluntario</button>',
////        'url' => '"ahorro/ahorro/create?id_ahorro=".$data->id',
////        'htmlOptions' => array(
////            'onClick' => 'js:save("#ahorro-deposito-form")'
////        ),
//    ));
    ?>

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'success',
        'icon' => 'icon-dollar',
        'label' => 'Nuevo Ahorro Extra',
//        'url' => "ahorro/ahorroExtra/create?id_ahorro=".$model->ahorro_id,
        'htmlOptions' => array(
//            'href' => 'ahorro/ahorroExtra/create/ahorro_id/'.$model->ahorro_id.'/cantidad_extra/'.$model->cantidad,
            'onclick' => 'js:AjaxActualizacionInformacion("#ahorroExtra-form")',
        ),
//        'active' => '($data->estado=="PAGADO")?false:true',
    ));
    ?>
</div>
<?php $this->endWidget(); ?>