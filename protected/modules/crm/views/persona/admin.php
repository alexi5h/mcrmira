<?php
/** @var PersonaController $this */
/** @var Persona $model */
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerScriptFile($baseUrl . '/plugins/bootstraptoogle/js/bootstrap2-toggle.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstraptoogle/css/bootstrap2-toggle.min.css');

$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');

Util::tsRegisterAssetJs('admin.js');

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create') . ' ' . Persona::label(), 'icon' => 'plus', 'url' => array('create'),
    ),
    array('label' => Yii::t('AweCrud.app', 'Exportar a Excel'), 'icon' => 'download-alt',
        'htmlOptions' => array(
            'onclick' => 'exporSocio("#persona-form")',)
    ),
);
?>

<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-briefcase"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo Persona::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <?php
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'id' => 'persona-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Persona_id">Socio</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                    <div class="control-group ">
                        <label class="control-label" for="Persona_sucursal">Sucursal</label>
                        <div class="controls">
                            <?php
                            $htmlOptions = array('class' => "span12");
                            echo $form->hiddenField($model, 'sucursal_id', $htmlOptions);
                            ?>
                            <span class="help-inline error" id="Persona_sucursal_id_em_" style="display: none"></span>
                        </div>
                    </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Persona_sexo">Género</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'sexo', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_sexo_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Persona_estado_civil">Estado Civil</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'estado_civil', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_estado_civil_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Persona_discapacidad">Discapacidad</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'discapacidad', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_discapacidad_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Persona_madre_soltera">Madre Soltera</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->checkbox($model, 'madre_soltera', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_madre_soltera_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>


        <div class="space20"></div>
        <div style='overflow:auto'> 
            <?php
            $this->widget('ext.bootstrap.widgets.TbGridView', array(
                'id' => 'persona-grid',
                'type' => 'striped bordered hover advance',
                'dataProvider' => $model->activos()->search(),
                'columns' => array(
                    array(
                        'name' => 'nombre_formato',
                        'value' => 'CHtml::link($data->nombre_formato, Yii::app()->createUrl("crm/persona/view",array("id"=>$data->id)))',
                        'type' => 'raw',
                    ),
                    'cedula',
                    //'ruc',
                    'telefono',
                    'celular',

                    array(
                        'name' => 'sucursal_id',
                        'value' => '$data->sucursal',
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {delete}',
                        'afterDelete' => 'function(link,success,data){ 
                    if(success) {
                         $("#flashMsg").empty();
                         $("#flashMsg").css("display","");
                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
                    }
                    }',
                        'buttons' => array(
                            'update' => array(
                                'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
                                'options' => array('title' => 'Editar'),
                                'url' => 'Yii::app()->createUrl("/crm/persona/update/id/".$data->id."/r/0")',
                                'imageUrl' => false,
                            //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
                            ),
                            'delete' => array(
                                'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
                                'options' => array('title' => 'Eliminar'),
                                'imageUrl' => false,
                            //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
                            ),
                        ),
                        'htmlOptions' => array(
                            'width' => '80px'
                        )
                    ),
                ),
            ));
            ?>                     
        </div>
    </div>
</div>