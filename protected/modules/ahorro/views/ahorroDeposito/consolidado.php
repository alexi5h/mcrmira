<?php
$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->getClientScript();


$cs->registerScriptFile($baseUrl . '/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
$cs->registerCssFile($baseUrl . '/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css');

$cs->registerScriptFile($baseUrl . '/plugins/daterangepicker/moment.min.js');
$cs->registerScriptFile($baseUrl . '/plugins/daterangepicker/daterangepicker.js');
$cs->registerCssFile($baseUrl . '/plugins/daterangepicker/daterangepicker-bs2.css');

$cs->registerScriptFile($baseUrl . '/plugins/select2/select2.js');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2.css');
$cs->registerCssFile($baseUrl . '/plugins/select2/select2-bootstrap.css');
Util::tsRegisterAssetJs('consolidado.js');
$anio_actual = $anio;
$anio_anterior = $anio_actual - 1;
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Exportar a Excel'), 'icon' => 'download-alt',
        'htmlOptions' => array(
            'onclick' => 'exporAhorro("#ahorro-deposito-form")',)
    )
);
?>

<div class="widget blue">
    <div class="widget-title">
        <h4>
            <i class="icon-money"></i> Consolidado
        </h4>
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
                    <label class="control-label" for="Persona_sucursal">Año</label>

                    <div class="controls">
                        <input type="text" style='cursor:pointer;' readonly = 'readonly' id="AhorroDepositoAnio" name="AhorroDeposito[anio]" value="<?php print $anio; ?>">

                    </div>
                </div>
            </div>

        </div>
        <?php $this->endWidget(); ?>
        <br/>

        <div style="overflow: auto;">

            <?php
            $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                'fixedHeader' => true,
                'headerOffset' => 40,
//                'responsiveTable' => true,
                'id' => 'consolidado-grid',
                'type' => 'striped bordered hover advance',
                'template' => '{items}',
                'dataProvider' => new CArrayDataProvider($data, array('pagination' => false)),
                'columns' => array(
                    array(
                        'value' => '$data["id"]',
                        'type' => 'raw',
                        'header' => 'Num'
                    ),
                    array(
                        'value' => '$data["Nombres"]',
                        'type' => 'raw',
                        'header' => 'Nombres'
                    ),
                    array(
                        'value' => '$data["Cedula"]',
                        'type' => 'raw',
                        'header' => 'Cedula'
                    ),
                    array(
                        'value' => '$data["Sucursal"]',
                        'type' => 'raw',
                        'header' => "Cantón"
                    ),
                    array(
                        'value' => '$data["Saldo"]',
                        'type' => 'raw',
                        'header' => "Saldo {$anio_anterior}",
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Enero"]',
                        'type' => 'raw',
                        'header' => 'Ene',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Febrero"]',
                        'type' => 'raw',
                        'header' => 'Feb',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Marzo"]',
                        'type' => 'raw',
                        'header' => 'Mar',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Abril"]',
                        'type' => 'raw',
                        'header' => 'Abr',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Mayo"]',
                        'type' => 'raw',
                        'header' => 'May',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Junio"]',
                        'type' => 'raw',
                        'header' => 'Jun',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Julio"]',
                        'type' => 'raw',
                        'header' => 'Jul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Agosto"]',
                        'type' => 'raw',
                        'header' => 'Ago',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Septiembre"]',
                        'type' => 'raw',
                        'header' => 'Sep',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Octubre"]',
                        'type' => 'raw',
                        'header' => 'Oct',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Noviembre"]',
                        'type' => 'raw',
                        'header' => 'Nov',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Diciembre"]',
                        'type' => 'raw',
                        'header' => 'Dic',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Total"]',
                        'type' => 'raw',
                        'header' => "Total {$anio_actual}",
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
