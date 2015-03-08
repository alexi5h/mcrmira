<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerScriptFile($baseUrl . '/plugins/daterangepicker/moment.min.js');
$cs->registerScriptFile($baseUrl . '/plugins/daterangepicker/daterangepicker.js');
$cs->registerCssFile($baseUrl . '/plugins/daterangepicker/daterangepicker-bs2.css');

$cs->registerScriptFile($baseUrl . '/plugins/bootstraptoogle/js/bootstrap2-toggle.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstraptoogle/css/bootstrap2-toggle.min.css');
$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');
Util::tsRegisterAssetJs('admin.js');
/** @var CreditoController $this */
/** @var Credito $model */
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('create'),
//    'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
    array('label' => Yii::t('AweCrud.app', 'Exportar a Excel'), 'icon' => 'download-alt',
        'htmlOptions' => array(
            'onclick' => 'exportCredito("#credito-form")',)
    ),
);
//$baseUrl = Yii::app()->baseUrl;
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-shopping-cart"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo Credito::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <?php
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'id' => 'credito-form',
            'enableAjaxValidation' => true,
            'clientOptions' => array('validateOnSubmit' => false, 'validateOnChange' => false,),
            'enableClientValidation' => false,
        ));
        ?>
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group ">
                    <label class="control-label" for="Credito_fecha_rango">Rango Fecha</label>
                    <div class="controls">
                        <input type="datetime" name="Credito[fecha_rango]" id="Credito_fecha_rango"
                               style="cursor: pointer;"/>
                    </div>
                </div>

            </div>
            <div class="span5">
                <div class="control-group ">
                    <label class="control-label" for="Credito_socio_id">Socio</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'socio_id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Credito_socio_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Credito_numero_cheque">NÃƒÂºmero Cheque</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'numero_cheque', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Credito_numero_cheque_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="space10"></div>-->
        <div class="row-fluid">
            <div class="span3">
                <div class="control-group ">
                    <label class="control-label" for="Credito_sucursal_id">Sucursal</label>
                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12");
                        echo $form->hiddenField($model, 'sucursal_id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Credito_sucursal_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>


        <div class="space15"></div>
        <div style="overflow: auto">
            <?php
            $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                'id' => 'credito-grid',
                'type' => 'striped bordered hover advance',
                'dataProvider' => $model->search(),
                'columns' => array(
                    array(
                        'header' => 'Código',
                        'name' => 'Id',
                        'value' => 'CHtml::link(Util::number_pad($data->id,5), Yii::app()->createUrl("credito/credito/view",array("id"=>$data->id)))',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'socio_id',
                        'value' => 'CHtml::link($data->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view", array("id" => $data->socio->id)))',
                        'type' => 'html'
                    ),
                    array(
                        'name' => 'garante_id',
                        'value' => 'CHtml::link($data->garante->nombre_formato, Yii::app()->createUrl("crm/persona/view", array("id" => $data->garante->id)))',
                        'type' => 'html'
                    ),
                    array(
                        'name' => 'fecha_credito',
                        'value' => 'Util::FormatDate($data->fecha_credito,"d/m/Y")'
                    ),
                    array(
                        'name' => 'fecha_limite',
                        'value' => 'Util::FormatDate($data->fecha_limite,"d/m/Y")'
                    ),
                    array(
                        'name' => 'cantidad_total',
                        'value' => '"$" . number_format($data->cantidad_total, 2)',
                        'class' => 'bootstrap.widgets.TbTotalSumColumnCurrency'
                    ),
                    array(
                        'name' => 'total_interes',
                        'value' => '"$" . number_format($data->total_interes, 2)',
                        'class' => 'bootstrap.widgets.TbTotalSumColumnCurrency'
                    ),
                    array(
                        'name' => 'total_pagar',
                        'value' => '"$" . number_format($data->total_pagar, 2)',
                        'class' => 'bootstrap.widgets.TbTotalSumColumnCurrency'
                    ),
                    array(
                        'name' => 'estado',
                        'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>