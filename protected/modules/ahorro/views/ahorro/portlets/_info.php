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
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'socio_id',
                    'value' => CHtml::link($model->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view",array("id"=>$model->socio_id))),
                    'type'=>'html'
                ),
                'cantidad',
                'fecha',
                'estado',
//                'tipo',
                'saldo_contra',
                'saldo_favor',
            ),
        ));
        ?>
    </div>
</div>