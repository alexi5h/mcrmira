<div class="row-fluid">
    <?php
    /** @var ActividadEconomicaController $this */
    /** @var ActividadEconomica $model */
    /** @var AweActiveForm $form */
    $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
        'type' => 'vertical',
        'id' => 'actividad-economica-form',        
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
        'enableClientValidation' => false,
    ));
    ?>



    <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 50,)) ?>

    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'type' => 'success',
            'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
            'htmlOptions' => array('onclick' => 'guardarActividadEconomicaPopouver("#actividad-economica-form","#nuevaSucursal")')
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('AweCrud.app', 'Cerrar'),
            'htmlOptions' => array('onclick' => '$("#nuevaSucursal").popover("hide")')
        ));
        ?>
    </div>
    <!--       </div>
        </div>-->
    <?php $this->endWidget(); ?>
</div>
