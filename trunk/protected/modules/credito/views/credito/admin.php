<?php
/** @var CreditoController $this */
/** @var Credito $model */
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('create'),
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
$tabla = Util::calculo_amortizacion(1200, 5, 18);
//$count=0;
//foreach ($tabla as $registro) {
//    $tabla[$count]['estado']='DEUDA';
//    $tabla[$count]['credito_id']=2;
//    $count++;
//}
////$linea1=  implode(',', $tabla[5]);
//$modelAmort=0;
$sumaInteres=0;
$sumaCuota=0;
$sumaAmort=0;
for ($i = 0; $i < count($tabla); $i++) {
//    $modelAmort=new CreditoAmortizacion;
//    $modelAmort->nro_cuota=$tabla[$i]['nro_cuota'];
//    $modelAmort->fecha_pago=$tabla[$i]['fecha_pago'];
//    $modelAmort->cuota=$tabla[$i]['cuota'];
//    $modelAmort->interes=$tabla[$i]['interes'];
//    $modelAmort->mora=$tabla[$i]['mora'];
//    $modelAmort->estado=$tabla[$i]['estado'];
//    $modelAmort->credito_id=$tabla[$i]['credito_id'];
//    $modelAmort->save();
    $sumaInteres+=$tabla[$i]['interes'];
    $sumaCuota+=$tabla[$i]['cuota'];
    $sumaAmort+=$tabla[$i]['amort'];
}
var_dump($sumaInteres.' '.$sumaCuota.' '.$sumaAmort);
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
                    'name' => 'socio_id',
                    'value' => '$data->socio->nombre_formato'
                ),
                array(
                    'name' => 'garante_id',
                    'value' => '$data->garante->nombre_formato'
                ),
                array(
                    'name' => 'sucursal_id',
                    'value' => '$data->sucursal',
                    'type' => 'raw',
                ),
                'fecha_credito',
                'fecha_limite',
                'cantidad_total',
                /*
                  'interes',
                  array(
                  'name' => 'estado',
                  'filter' => array('DEUDA'=>'DEUDA','PAGADO'=>'PAGADO',),
                  ),
                 */
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update} {delete}',
                    'afterDelete' => 'function(link,success,data){ 
                    if(success) {
                         $("#flashMsg").empty();
                         $("#flashMsg").css("display","");
                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
                    }
                    }',
                    'buttons' => array(
                        'update' => array(
                            'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
                            'options' => array('title' => 'Actualizar'),
                            'imageUrl' => false,
                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
                        ),
                        'delete' => array(
                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
                            'options' => array('title' => 'Eliminar'),
                            'imageUrl' => false,
                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
                        ),
                    ),
                    'htmlOptions' => array(
                        'width' => '80px'
                    )
                ),
            ),
        ));
        ?>
    </div>
</div>