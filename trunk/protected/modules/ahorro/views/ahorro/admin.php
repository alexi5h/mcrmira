<?php
/** @var AhorroController $this */
/** @var Ahorro $model */
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();


$cs->registerScriptFile($baseUrl . '/plugins/daterangepicker/moment.min.js');
$cs->registerScriptFile($baseUrl . '/plugins/daterangepicker/daterangepicker.js');
$cs->registerCssFile($baseUrl . '/plugins/daterangepicker/daterangepicker-bs2.css');

$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');

Util::tsRegisterAssetJs('admin.js');
$this->menu = array(
//    array('label' => Yii::t('AweCrud.app', 'Registrar') . ' ' . Ahorro::label(1), 'icon' => 'plus', 'url' => array('create'),),
    array('label' => Yii::t('AweCrud.app', 'Depositar'), 'icon' => 'plus', 'htmlOptions' => array(
        'onclick' => 'js:viewModal("ahorro/ahorroDeposito/createDepositoAhorro",function(){maskAttributes();})',)
    ),
    array('label' => Yii::t('AweCrud.app', 'Exportar a Excel'), 'icon' => 'download-alt',
        'htmlOptions' => array(
            'onclick' => 'exporAhorro("#ahorro-form")',)
    ),
);
?>
<div id="flashMsg" class="flash-messages">

</div>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-money"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo Ahorro::label(2) ?>
        </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
        </span>
    </div>
    <div class="widget-body">
        <?php
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'id' => 'ahorroDeposito-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="row-fluid ">
            <div class="span3">
                <div class="control-group ">
                    <label class="control-label" for="Ahorro_fecha_rango">Rango Fecha</label>

                    <div class="controls">
                        <input type="datetime" name="Ahorro[fecha_rango]" id="Ahorro_fecha_rango"
                               style="cursor: pointer;"/>
                    </div>
                </div>

            </div>

            <div class="span5">
                <div class="control-group ">
                    <label class="control-label" for="Ahoro_socio_id">Socio</label>

                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'socio_id', $htmlOptions);
                        ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Ahorro_sucursal_id">Cantón</label>

                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'sucursal_id', $htmlOptions);
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->endWidget(); ?>

        <div id="contentGrid" style="height: 335px">

        <?php
        $this->widget('bootstrap.widgets.TbExtendedGridView', array(
            'id' => 'ahorro-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->de_tipo(Ahorro::TIPO_OBLIGATORIO)->search(),
            'columns' => array(
                array(
                    'header' => 'Código',
                    'name' => 'Id',
                    'value' => 'CHtml::link(Util::number_pad($data->id,5), Yii::app()->createUrl("ahorro/ahorro/view",array("id"=>$data->id)))',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'socio_id',
                    'value' => 'CHtml::link($data->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view",array("id"=>$data->socio->id)))',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Cédula',
                    'value' => '$data->socio->cedula',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Sucursal',
                    'value' => '$data->sucursal->nombre',
                    'type' => 'raw'
                ),
//                'cantidad',
                array(
                    'name'=>'cantidad',
//                    'header'=>'Hours worked',
                    'class'=>'bootstrap.widgets.TbTotalSumColumn'
                ),
                array(
                    'name' => 'fecha',
                    'value' => 'Util::FormatDate($data->fecha,"d/m/Y")',
                ),

                array('name'=>'estado'),

                array(
                    'name'=>'saldo_contra',
                    'class'=>'bootstrap.widgets.TbTotalSumColumn'
                )
//                array(
//                    'class' => 'CButtonColumn',
//                    'template' => '{pago}',
//                    'afterDelete' => 'function(link,success,data){ 
//                    if(success) {
//                         $("#flashMsg").empty();
//                         $("#flashMsg").css("display","");
//                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
//                    }
//                    }',
//                    'buttons' => array(
//                        'pago' => array(
//                            'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i></button>',
//                            'options' => array('title' => 'Realizar deposito'),
//                            'url' => '"ahorro/ahorroDeposito/create?id_ahorro=".$data->id',
//                            'click' => 'function(e){e.preventDefault(); viewModalWidth($(this).attr("href"),function() {maskAttributes();});  return false; }',
//                            'imageUrl' => false,
//                            'visible' => '($data->saldo_contra==0)||($data->estado=="PAGADO")?false:true',
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
</div>