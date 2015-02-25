<div class="widget green">
    <div class="widget-title">
        <h4> <i class="icon-dollar"></i> <?php echo CreditoAmortizacion::label() ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <div style="overflow: auto">
            <?php
            $amortizaciones = CreditoAmortizacion::model()->de_credito($model->id)->search();
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'credito-amortizacion-big-grid',
//                'type' => 'striped bordered hover advance',
                'template' => '{items}{summary}{pager}',
                'dataProvider' => $amortizaciones,
                'columns' => array(
//                    'nro_cuota',
                    array(
                        'header' => 'Nº',
                        'name' => 'nro_cuota',
                        'value' => '$data->nro_cuota',
                        'type' => 'raw',
                    ),
                    array(
                        'name' => 'fecha_pago',
                        'value' => 'Util::FormatDate($data->fecha_pago, "d/m/Y")',
                    ),
                    'cuota',
                    'saldo_contra',
                    'saldo_favor',
//                    'interes',
//                    'mora',
                    array(
                        'name' => 'estado',
                        'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                    ),
                ),
                'htmlOptions' => array('style' => 'padding-top: 5px;'),
            ));
            ?>
        </div>
    </div>
</div>