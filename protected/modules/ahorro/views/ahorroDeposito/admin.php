<?php
/** @var AhorroDepositoController $this */
/** @var AhorroDeposito $model */
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerScriptFile($baseUrl . '/plugins/bootstraptoogle/js/bootstrap2-toggle.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstraptoogle/css/bootstrap2-toggle.min.css');

$cs->registerScriptFile($baseUrl . '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css');

$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');

Util::tsRegisterAssetJs('admin.js');

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Realizar Deposito'), 'icon' => 'plus', 'url' => array('createDeposito'),
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
    array('label' => Yii::t('AweCrud.app', 'Exportar'), 'icon' => 'download-alt', 'url' => '#',
        'htmlOptions' => array(
            'onClick' => 'exporSocio("#ahorro-deposito-form")'
        )
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-money"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo AhorroDeposito::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'id' => 'ahorro-deposito-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="AhorroDeposito_socio_id">Socio</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'socio_id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>

            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="AhorroDeposito_sucursal_comprobante_id">Cantón</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'sucursal_comprobante_id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_sucursal_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="AhorroDeposito_fecha_comprobante_entidad">Fecha</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'fecha_comprobante_entidad',array('placeholder'=>'Fecha')) ?>

                        <span class="help-inline error" id="Persona_sucursal_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>

        </div>

        <?php $this->endWidget(); ?>

        <?php
        $this->widget('bootstrap.widgets.TbExtendedGridView', array(
            'id' => 'ahorro-deposito-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->search(),
            'columns' => array(
                array(
                    'name' => 'socio_id',
                    'value' => 'CHtml::link($data->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view", array("id"=>$data->socio_id)))',
                    'type' => 'html'
                ),
                array(
                    'header' => 'Cédula',
                    'value' => '$data->socio->cedula'
                ),
                array(
                    'header' => 'Cantidad',
                    'name' => 'cantidad',
                    'value' => '$data->cantidad',
                    'class' => 'bootstrap.widgets.TbTotalSumColumn'
                ),
                array(
                    'name' => 'fecha_comprobante_entidad',
                    'value' => 'Util::FormatDate($data->fecha_comprobante_entidad, "d/m/Y")',
                ),
//                        'entidad_bancaria_id',
                'cod_comprobante_entidad',
                array(
                    'name' => 'sucursal_comprobante_id',
                    'value' => '$data->sucursal'
                ),
//                'cod_comprobante_su',
            /*
              'fecha_comprobante_su',
              array(
              'name' => 'pago_id',
              'value' => 'isset($data->pago) ? $data->pago : null',
              'filter' => CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn()),
              ),
             */
//                array(
//                    'class' => 'CButtonColumn',
//                    'template' => '{update} {delete}',
//                    'afterDelete' => 'function(link,success,data){ 
//                    if(success) {
//                         $("#flashMsg").empty();
//                         $("#flashMsg").css("display","");
//                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
//                    }
//                    }',
//                    'buttons' => array(
//                        'update' => array(
//                            'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
//                            'options' => array('title' => 'Editar'),
//                            'imageUrl' => false,
//                             //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
//                        ),
//                        'delete' => array(
//                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                            'options' => array('title' => 'Eliminar'),
//                            'imageUrl' => false,
//                            //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
//                        ),
//                    ),
//                    'htmlOptions' => array(
//                        'width' => '80px'
//                    )
//                ),
            ),
        ));
        ?>
    </div>
</div>