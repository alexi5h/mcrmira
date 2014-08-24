<?php ?>

<div class="widget bluesky">
    <div class="widget-title">
        <h4> <i class="icon-money"></i> <?php echo Yii::t('AweCrud.app', 'View'); ?> <?php echo Ahorro::label() ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">


        <?php
//        var_dump($model->socio);
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'socio_id',
                    'value' => $model->socio->nombre_formato,
                ),
                'cantidad',
                'fecha',
                'estado',
                'tipo',
                'saldo_contra',
                'saldo_favor',
                'saldo_extra',
                array(
                    'name' => 'anulado',
                    'type' => 'boolean'
                ),
                'descripcion',
            ),
        ));
        ?>
    </div>
</div>