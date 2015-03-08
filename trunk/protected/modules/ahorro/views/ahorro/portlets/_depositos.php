<div class="widget red">
    <div class="widget-title">
        <h4> <i class="icon-dollar"></i> <?php echo AhorroDeposito::label() ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <div style="overflow: auto">
            <?php
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'ahorro-deposito-grid',
                'type' => 'striped bordered hover advance',
                'dataProvider' => new CArrayDataProvider($model->ahorroDetalles),
                'columns' => array(
                    array(
                        'header' => "Cantidad",
                        'name' => 'cantidad',
                        'value' => 'number_format($data->cantidad, 2)',
                    ),

                    array(
                        'header' => 'Fecha',
                        'value' => 'Util::FormatDate($data->fecha, "d/m/Y")',
                    ),
//                'sucursal_comprobante_id',
//                'cod_comprobante_su',
                /*
                  'fecha_comprobante_su',
                  array(
                  'name' => 'pago_id',
                  'value' => 'isset($data->pago) ? $data->pago : null',
                  'filter' => CHtml::listData(Ahorro::model()->findAll(), 'id', Ahorro::representingColumn()),
                  ),
                 */
//                array(
//                    'class' => 'CButtonColumn',
//                    'template' => '{update} ',
//                    'afterDelete' => 'function(link,success,data){ 
//                    if(success) {
//                         $("#flashMsg").empty();
//                         $("#flashMsg").css("display","");
//                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
//                    }
//                    }',
//                    'buttons' => array(
//                        'update' => array(
//                            'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
//                            'options' => array('title' => 'Actualizar'),
//                            'imageUrl' => false,
//                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
//                        ),
//
//                    ),
//                    'htmlOptions' => array(
//                        'width' => '80px'
//                    )
//                ),
                ),
            ));
            ?>
            <br>
            <?php
//            if ($model->saldo_contra > 0) {
//                $this->widget('bootstrap.widgets.TbButton', array(
//                    'type' => 'default',
//                    'icon' => 'plus',
//                    'label' => 'Depositar',
//                    'htmlOptions' => array(
////                        'href' => 'ahorro/ahorroDeposito/create?id_ahorro=' . $model->id,
//                        'onClick' => 'js:viewModalWidth("ahorro/ahorroDeposito/create?id_ahorro=' . $model->id . '",function() {maskAttributes();}); ',
//                    ),
//                ));
//            }
            ?>
        </div>
    </div>
</div>