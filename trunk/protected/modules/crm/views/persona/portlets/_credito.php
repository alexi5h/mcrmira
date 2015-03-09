<?php
//$modelAmortizacionesComp = CreditoAmortizacion::model()->en_deuda()->de_credito(15)->findAll();
//var_dump($modelAmortizacionesComp);
$creditos = new Credito;
?>
<?php $validarDataCreditos = $creditos->de_socio($model->id)->count() > 0 ?>
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
                    $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                        'id' => 'credito-grid',
                        'type' => 'striped bordered hover advance',
                        'dataProvider' => $creditos->de_socio($model->id)->search(),
                        'columns' => array(
                            array(
                                'header' => 'Código',
                                'name' => 'Id',
                                'value' => 'CHtml::link(Util::number_pad($data->id,5), Yii::app()->createUrl("credito/credito/view",array("id"=>$data->id)))',
                                'type' => 'raw',
                            ),
                            array(
                                'name' => 'garante_id',
                                'value' => '$data->garante->nombre_formato'
                            ),
//                            'saldo_contra',
//                            'saldo_favor',
                            array(
                                'name' => 'cantidad_total',
                                'value' => '"$" . number_format($data->cantidad_total, 2)',
                                'class' => 'bootstrap.widgets.TbTotalSumColumnCurrency'
                            ),
                            array(
                                'name' => 'total_interes',
                                'value' => '"$" . number_format($data->total_interes, 2)',
                                'class' => 'bootstrap.widgets.TbTotalSumColumnCurrency'
                            ),
                            array(
                                'name' => 'total_pagar',
                                'value' => '"$" . number_format($data->total_pagar, 2)',
                                'class' => 'bootstrap.widgets.TbTotalSumColumnCurrency'
                            ),
                            'estado',
                            /*
                              'interes',
                              array(
                              'name' => 'estado',
                              'filter' => array('DEUDA'=>'DEUDA','PAGADO'=>'PAGADO',),
                              ),
                             */
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update}',
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
//                                    'delete' => array(
//                                        'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                                        'options' => array('title' => 'Eliminar'),
//                                        'imageUrl' => false,
//                                    //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
//                                    ),
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