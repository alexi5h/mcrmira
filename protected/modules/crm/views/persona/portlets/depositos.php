<?php
$ahorros = new AhorroDeposito;
$ahorros = $ahorros->de_socio($model->id)->search();
$validarDepositos = $ahorros->itemCount;
?>
<div class="widget red">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Depositos</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--<a href="javascript:;" class="icon-remove"></a>-->
        </span>
    </div>
    <div class="widget-body" >


        <div class="row-fluid">
            <?php
//            $this->widget(
//                    'bootstrap.widgets.TbButton', array(
//                'id' => 'add-Cobranza',
//                'label' => $validarDepositos ? 'Agregar Ahorro' : '<h3 >Agregar Ahorro</h3>',
//                'encodeLabel' => false,
//                'icon' => $validarDepositos ? 'plus-sign' : 'dollar',
//                'htmlOptions' => array(
//                    'onClick' => 'js:viewModal("ahorro/ahorro/ajaxCreate/socio_id/' . $model->id . '",function(){'
//                    . 'maskAttributes();},false)',
//                    'class' => $validarDepositos ? '' : 'empty-portlet',
//                ),
//                    )
//            );
            ?>
            <?php
//        
            $this->widget('bootstrap.widgets.TbButton', array(
                'id' => 'add-Deposito',
                'label' => $validarDepositos ? 'Depositar' : '<h3 >Depositar</h3>',
                'encodeLabel' => false,
                'icon' => 'plus-sign',
                'htmlOptions' => array(
                    'class' => $validarDepositos ? '' : 'empty-portlet',
                    'onClick' => 'js:viewModal("ahorro/ahorroDeposito/createDeposito/socio_id/"+' . $model->id . ',function(){maskAttributes();})',
                ),
                    )
            );
//            }
            ?>       
            <div  class="row-fluid" style='overflow:auto; height: 200px ' id="wrapper_grid_deposito" <?php echo $validarDepositos > 0 ? '' : 'hidden' ?>> 
                <?php
                $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                    'id' => 'ahorro-deposito-grid',
                    'type' => 'striped bordered hover advance',
//                    'fixedHeader' => true,
//                    'headerOffset' => 40,
                    'dataProvider' => $ahorros,
                    'columns' => array(
                        array(
                            'header' => 'Cantidad',
                            'name' => 'cantidad',
                            'value' => '$data->cantidad',
                            'class' => 'bootstrap.widgets.TbTotalSumColumn'
                        ),
                        array(
                            'name' => 'fecha_comprobante_entidad',
                            'value' => 'Util::FormatDate($data->fecha_comprobante_entidad, "d/m/Y")',
                        ),
                        'cod_comprobante_entidad',
//                        'entidad_bancaria_id',
//                            array(
//                                'name' => 'sucursal_comprobante_id',
//                                'value' => '$data->sucursal'
//                            ),
//                'cod_comprobante_su',
                    /*
                      'fecha_comprobante_su',
                      array(
                      'name' => 'pago_id',
                      'value' => 'isset($data->pago) ? $data->pago : null',
                      'filter' => CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn()),
                      ),
                     */
                    ),
                ));
                echo '<br/>';
                ?>
            </div>
        </div>
    </div>
</div>