<?php
//$modelAmortizacionesComp = CreditoAmortizacion::model()->en_deuda()->de_credito(15)->findAll();
//var_dump($modelAmortizacionesComp);
$creditos = new Credito;
?>
<?php $validarDataCreditos = $creditos->de_socio($model->id)->en_deuda()->count() > 0 ?>
<?php if ($validarDataCreditos): ?>
    <div class="widget black">
        <div class="widget-title">
            <h4><i class="icon-tasks"></i> Crédito</h4>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>
                <!--<a href="javascript:;" class="icon-remove"></a>-->
            </span>
        </div>
        <div class="widget-body">

            <div class="row-fluid">
                <div style='overflow:auto'> 
                    <?php
                    $this->widget('bootstrap.widgets.TbGridView', array(
                        'id' => 'credito-grid',
                        'type' => 'striped bordered hover advance',
                        'dataProvider' => $creditos->de_socio($model->id)->en_deuda()->search(),
                        'columns' => array(
//                            array(
//                                'name' => 'socio_id',
//                                'value' => '$data->socio->nombre_formato'
//                            ),
                            array(
                                'name' => 'garante_id',
                                'value' => '$data->garante->nombre_formato'
                            ),
//                            array(
//                                'name' => 'sucursal_id',
//                                'value' => '$data->sucursal',
//                                'type' => 'raw',
//                            ),
//                            array(
//                                'name' => 'fecha_credito',
//                                'value' => 'Util::FormatDate($data->fecha_credito, "d-m-Y")',
//                                'type' => 'raw',
//                            ),
//                            array(
//                                'name' => 'fecha_limite',
//                                'value' => 'Util::FormatDate($data->fecha_limite, "d-m-Y")',
//                                'type' => 'raw',
//                            ),
                            'cantidad_total',
//                            'total_interes',
                            'total_pagar',
                            'saldo_contra',
                            'saldo_favor',
                            /*
                              'interes',
                              array(
                              'name' => 'estado',
                              'filter' => array('DEUDA'=>'DEUDA','PAGADO'=>'PAGADO',),
                              ),
                             */
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update}{delete}',
                                'afterDelete' => 'function(link,success,data){ 
                    if(success) {
                         $("#flashMsg").empty();
                         $("#flashMsg").css("display","");
                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
                    }
                    }',
                                'buttons' => array(
                                    'update' => array(
                                        'label' => '<button class="btn btn-warning"><i class="icon-dollar"></i></button>',
                                        'options' => array('title' => 'Realizar deposito'),
                                        'url' => '"credito/creditoDeposito/create?credito_id=".$data->id',
                                        'click' => 'function(e){e.preventDefault(); viewModalWidth($(this).attr("href"),function() {maskAttributes();});  return false; }',
                                        'imageUrl' => false,
                                        'visible' => '($data->estado=="PAGADO")?false:true',
                                    ),
                                    'delete' => array(
                                        'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
                                        'options' => array('title' => 'Eliminar'),
                                        'imageUrl' => false,
                                    //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'width' => '40px'
                                )
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>