<?php ?>

<div class="widget bluesky">
    <div class="widget-title">
        <h4> <i class="icon-money"></i> <?php echo Yii::t('AweCrud.app', 'View'); ?> <?php echo Credito::label() ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'socio_id',
                    'value' => $model->socio->nombre_formato,
                ),
                array(
                    'name' => 'garante_id',
                    'value' => $model->garante->nombre_formato,
                ),
                array(
                    'name' => 'fecha_credito',
                    'value' => Util::FormatDate($model->fecha_credito, 'd-m-Y'),
                ),
                array(
                    'name' => 'cantidad_total',
                    'value' => '$'.$model->cantidad_total,
                ),
                array(
                    'name' => 'total_interes',
                    'value' => '$'.$model->total_interes,
                ),
                array(
                    'name' => 'total_pagar',
                    'value' => '$'.$model->total_pagar,
                ),
                'periodos',
                'estado',
                'numero_cheque'
            ),
        ));
        ?>
    </div>
</div>