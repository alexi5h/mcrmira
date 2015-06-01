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
                    'value' => CHtml::link($model->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view", array("id" => $model->socio->id))),
                    'type' => 'html'
                ),
                array(
                    'name' => 'garante_id',
                    'value' => CHtml::link($model->garante->nombre_formato, Yii::app()->createUrl("crm/persona/view", array("id" => $model->garante->id))),
                    'type' => 'html'
                ),
                array(
                    'name' => 'fecha_credito',
                    'value' => Util::FormatDate($model->fecha_credito, 'd/m/Y'),
                ),
                array(
                    'name' => 'cantidad_total',
                    'value' => '$' . number_format($model->cantidad_total, 2),
                ),
//                array(
//                    'name' => 'total_interes',
//                    'value' => '$' . number_format($model->total_interes, 2),
//                ),
                array(
                    'name' => 'total_pagar',
                    'value' => '$' . number_format($model->total_pagar, 2),
                ),
                'periodos',
                array(
                    'name' => 'cuota_capital',
                    'value' => '$' . number_format($model->cuota_capital, 2),
                ),
                'estado',
                'numero_cheque'
            ),
        ));
        ?>
    </div>
</div>