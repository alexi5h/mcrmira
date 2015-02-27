<?php
/** @var PersonaController $this */
/** @var Persona $model */
Util::tsRegisterAssetJs('admin.js');

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create') . ' ' . Persona::label(), 'icon' => 'plus', 'url' => array('create'),
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
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
//                'type' => 'horizontal',
//    'action' =>Yii::app()->createUrl('/campanias/campania/update', array('id' => $model->id)),
//    'action' => $model->isNewRecord ? Yii::app()->createUrl('/campanias/campania/create') : Yii::app()->createUrl('/campanias/campania/update', array('id' => $model->id)),
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="span4">
                    <!--<div class="control-label">&nbsp;</div>-->
                    <br>

                    <?php
                    $this->widget('ext.search.TruuloModuleSearch', array(
                        'model' => $model,
                        'grid_id' => 'persona-grid',
                    ));
                    ?>
                </div>


                <div class="span4">
                    <div class="control-label">Cant&oacute;n </div>

                    <?php
                    $this->widget(
                            'ext.bootstrap.widgets.TbSelect2', array('model' => $model,
                        'attribute' => 'direccion_domicilio_id',
                        'data' => (CHtml::listData(Canton::model()->findAll(), 'id', Canton::representingColumn())) ? array('0' => '- Todos -') + CHtml::listData(Canton::model()->findAll(), 'id', Canton::representingColumn()) : array(null),
                        'options' => array(),
                        'htmlOptions' => array(
                            'multiple' => 'multiple',
//                    'style' => 'width:100%',
                        ),
                        'events' => array(
                            'change' => 'js: function(e) {select2validar(e,"s2id_Persona_direccion_domicilio_id");}',
                        )
                            )
                    );
                    ?>
                </div>
                <div class="span4">
                    <div class="control-label">G&eacute;nero </div>

                    <?php
                    echo $form->dropDownList($model, 'sexo', array('-- seleccione --', 'M' => 'Masculino', 'F' => 'Femenino',));
                    ?>
                </div>


            </div>
            <div class="row-fluid">
                <div class="span4">
                    <div class="control-label">Estado Civ&iacute;l </div>

                    <?php
                    echo $form->dropDownList(
                            $model, 'estado_civil', array('-- seleccione --', 'SOLTERO' => 'Soltero', 'CASADO' => 'Casado', 'DIVORCIADO' => 'Divorciado', 'VIUDO' => 'Viudo',));
                    ?>
                </div>
                <div class="span4">
                    <div class="control-label">Discapacidad </div>

                    <?php
                    echo $form->dropDownList(
                            $model, 'discapacidad', array('-- seleccione --', 'SI' => 'SI', 'NO' => 'NO'));
                    ?>
                </div>
                <div class="span4">
                    <!--<div class="control-label">Made Soltera</div>-->
                    <br>
                    Made Soltera&nbsp;&nbsp;

                    <?php
                    echo $form->checkBox($model, 'madre_soltera');
                    ?>
                </div>

            </div>
        </div>
        <?php $this->endWidget(); ?>
        <div class="row-fluid">
            <!--BOTON DE BUSCAR--> 
            <div class="pull-right">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'icon' => 'icon-search',
                    'type' => 'primary',
                    'label' => Yii::t('AweCrud.app', 'Buscar'),
                    'htmlOptions' => array(
                        'id' => 'buttonbuscar',
                        'onClick' => 'js:generarGridAdminPersonas("#persona-form");',
                    ),
                ));
                ?>
            </div>

            <!--FIN BUSCAR-->

            <!--BOTON DE QUITAR FILTROS--> 
            <div class="pull-right span2">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'icon' => 'icon-refresh',
                    'type' => 'danger',
                    'label' => Yii::t('AweCrud.app', 'Quitar Filtros'),
                    'htmlOptions' => array(
                        'id' => 'buttonquitar',
                        'onClick' => 'js:generarGridAdminPersonasTodos("#persona-form");',
                        'class' => 'hidden'
                    ),
                ));
                ?>
            </div>
        </div>
        <!--FIN QUITAR FILTROS-->

        <div class="space20"></div>
        <div style='overflow:auto'> 
            <?php
            $this->widget('ext.bootstrap.widgets.TbGridView', array(
                'id' => 'persona-grid',
                'type' => 'striped bordered hover advance',
                'dataProvider' => $model->activos()->search(),
//                'dataProvider' => $model->de_tipo(Persona::TIPO_CLIENTE)->activos()->search(),
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
//                    'email',
//                    array(
//                        'name' => 'persona_etapa_id',
//                        'value' => '$data->personaEtapa',
//                        'type' => 'raw',
//                    ),
                    array(
                        'name' => 'sucursal_id',
                        'value' => '$data->sucursal',
                        'type' => 'raw',
                    ),
//                    'aprobado',
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