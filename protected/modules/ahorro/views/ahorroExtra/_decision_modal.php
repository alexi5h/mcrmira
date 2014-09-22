<?php
Yii::app()->clientScript->scriptMap['jquery.js'] = false;

//Util::tsRegisterAssetJs('_decision_modal.js');
?>
<div class="modal-header">

    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-user"></i> Registrar Ahorro Voluntario</h4>
</div>
<div class="modal-body">
    <div class="row-fluid">
        <div class="span6">

        </div>

    </div>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success',
//        'icon' => 'ok',
        'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i> Nuevo Ahorro Voluntario</button>',
//        'url' => '"ahorro/ahorro/create?id_ahorro=".$data->id',
//        'htmlOptions' => array(
//            'onClick' => 'js:save("#ahorro-deposito-form")'
//        ),
    ));
    ?>

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'icon' => 'remove',
        'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i> Nuevo Ahorro Extra</button>',
//        'url' => "ahorro/ahorroExtra/create?id_ahorro=".$model->ahorro_id,
        'htmlOptions' => array(
            'href'=>"ahorro/ahorroExtra/create?id_ahorro=".$model->ahorro_id,
            'onclick' => 'AjaxActualizacionInformacion("#ahorroExtra-form")',
            
        ),
//        'active' => '($data->estado=="PAGADO")?false:true',
    ));
    ?>
</div>

<!------- FORM AHORRO EXTRA ------->

<?php
/** @var AhorroExtraController $this */
/** @var AhorroExtra $model */
/** @var AweActiveForm $form */
$form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
    'type' => 'horizontal',
    'id' => 'ahorroextra-form',
//    'enableAjaxValidation' => true,
//    'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => true,),
//    'enableClientValidation' => false,
        ));
?>
    <div class="hidden">

<?php echo $form->textFieldRow($model, 'cantidad', array('maxlength' => 10)) ?>


        <?php echo $form->dropDownListRow($model, 'anulado', array('SI' => 'SI', 'NO' => 'NO',)) ?>

        <?php echo $form->dropDownListRow($model, 'ahorro_id', array('' => ' -- Seleccione -- ') + CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn())) ?>

            <?php echo $form->textFieldRow($model, 'socio_id') ?>
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
<?php $this->endWidget(); ?>
