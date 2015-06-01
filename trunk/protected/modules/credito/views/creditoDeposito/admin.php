<?php
/** @var CreditoDepositoController $this */
/** @var CreditoDeposito $model */
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();

$cs->registerScriptFile($baseUrl . '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css');

$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');
Util::tsRegisterAssetJs('admin.js');

$anio_actual = $anio;
$anio_anterior = $anio_actual - 1;

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Exportar a Excel'), 'icon' => 'download-alt',
        'htmlOptions' => array(
            'onclick' => 'exportCredito("#credito-deposito-form")',)

    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-fire-extinguisher"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo CreditoDeposito::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php
        $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'id' => 'credito-deposito-form',
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
                        echo $form->hiddenField($model, 'socio_id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>

            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="Persona_sucursal">Cantón</label>

                    <div class="controls">
                        <?php
                        $htmlOptions = array('class' => "span12", 'selected-text' => $model->sucursal->nombre);
                        echo $form->hiddenField($model, 'sucursal_comprobante_id', $htmlOptions);
                        ?>
                        <span class="help-inline error" id="Persona_sucursal_id_em_" style="display: none"></span>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group ">
                    <label class="control-label" for="CreditoDepositoAnio">Año</label>

                    <div class="controls">
                        <input type="text" style='cursor:pointer;' readonly='readonly' id="CreditoDepositoAnio"
                               name="CreditoDeposito[anio]" value="<?php print $anio; ?>">

                    </div>
                </div>
            </div>

        </div>
        <?php $this->endWidget(); ?>
        <div style="overflow-x:auto;">
            <?php
            $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                'fixedHeader' => true,
                'headerOffset' => 40,
//                'responsiveTable' => true,
                'id' => 'credito-deposito-grid',
                'type' => 'striped bordered hover advance',
                'template' => '{items}',
                'dataProvider' => new CArrayDataProvider($data, array('pagination' => false)),
                'columns' => array(
                    array(
                        'value' => '$data["numero_cheque"]',
                        'type' => 'raw',
                        'header' => 'Num'
                    ),
                    array(
                        'value' => '$data["Nombres"]',
                        'type' => 'raw',
                        'header' => 'Nombres'
                    ),
                    array(
                        'value' => '$data["fecha_credito"]',
                        'type' => 'raw',
                        'header' => "F Crédito"
                    ),
                    array(
                        'value' => '$data["pagos_ant"]',
                        'type' => 'raw',
                        'header' => "Cap {$anio_anterior}",
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["interes_ant"]',
                        'type' => 'raw',
                        'header' => "Int {$anio_anterior}",
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Enero"]',
                        'type' => 'raw',
                        'header' => 'Enero',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Enero"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Enero"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Febrero"]',
                        'type' => 'raw',
                        'header' => 'Febrero',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Febrero"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Febrero"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Marzo"]',
                        'type' => 'raw',
                        'header' => 'Marzo',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Marzo"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Marzo"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Abril"]',
                        'type' => 'raw',
                        'header' => 'Abril',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Abril"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Abril"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Mayo"]',
                        'type' => 'raw',
                        'header' => 'Mayo',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Mayo"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Mayo"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Junio"]',
                        'type' => 'raw',
                        'header' => 'Junio',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Junio"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Junio"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Julio"]',
                        'type' => 'raw',
                        'header' => 'Julio',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Julio"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Julio"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Agosto"]',
                        'type' => 'raw',
                        'header' => 'Agosto',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Agosto"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Agosto"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Septiembre"]',
                        'type' => 'raw',
                        'header' => 'Septiembre',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Septiembre"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Septiembre"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Octubre"]',
                        'type' => 'raw',
                        'header' => 'Octubre',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Octubre"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Octubre"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Noviembre"]',
                        'type' => 'raw',
                        'header' => 'Noviembre',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Noviembre"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Noviembre"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data["Diciembre"]',
                        'type' => 'raw',
                        'header' => 'Diciembre',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[0]["Diciembre"]',
                        'type' => 'raw',
                        'header' => 'Int',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                    array(
                        'value' => '$data[1]["Diciembre"]',
                        'type' => 'raw',
                        'header' => 'Mul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'
                    ),
                ),
            ));
            ?>
        </div>

    </div>
</div>