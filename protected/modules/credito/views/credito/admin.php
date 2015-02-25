<?php
/** @var CreditoController $this */
/** @var Credito $model */
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('create'),
//    'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
$baseUrl = Yii::app()->baseUrl;
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
        $this->widget('bootstrap.widgets.TbGridView', array(
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
                    'value' => '$data->socio->nombre_formato'
                ),
                array(
                    'name' => 'garante_id',
                    'value' => '$data->garante->nombre_formato'
                ),
                'fecha_credito',
                'fecha_limite',
                'cantidad_total',
                'total_interes',
                'total_pagar',
                array(
                    'name' => 'estado',
                    'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                ),
            ),
        ));
        ?>
    </div>
</div>