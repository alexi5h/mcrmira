<div class="widget-body">
    <?php
    /** @var ActividadEconomicaController $this */
    /** @var ActividadEconomica $model */
    /** @var AweActiveForm $form */
    $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
        'type' => 'vertical',
        'id' => 'actividad-economica-form',
        'action' => Yii::app()->baseUrl . '/crm/actividadEconomica/create/popoup/1',
        'enableAjaxValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true, 'validateOnChange' => false,),
        'enableClientValidation' => false,
    ));
    ?>

    <!--<div class="control-group">-->
    <?php echo $form->textFieldRow($model, 'nombre', array('maxlength' => 50)) ?>

    <!--</div>-->

    <div class="form-actions">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'type' => 'success',
            'label' => $model->isNewRecord ? Yii::t('AweCrud.app', 'Create') : Yii::t('AweCrud.app', 'Save'),
            'htmlOptions' => array('onclick' => 'guardarActividadEconomicaPopouver("#actividad-economica-form","#nuevaSucursal","Persona_actividad_economica_id")')
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
