<?php
// Obtener pagos del cliente
$pagos = Pago::model()->de_cliente($model->id)->findAll();
$model_pagos = new CArrayDataProvider($pagos, array('pagination' => array('pageSize' => 5)));
//var_dump($model_pagos->id);
//die();
?>

<div class="widget red">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Pagos</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--<a href="javascript:;" class="icon-remove"></a>-->
        </span>
    </div>
    <div class="widget-body">
        <div class="row-fluid">
            <div style='overflow:auto'> 
                <?php
                $this->widget('ext.bootstrap.widgets.TbGridView', array(
                    'id' => 'pago-grid',
//                        'afterAjaxUpdate' => "function(id,data){AjaxActualizarActividades();}",
                    'type' => 'striped bordered hover advance',
                    'dataProvider' => $model_pagos,
                    'columns' => array(
                        array(
                            'header' => 'ID',
                            'name' => 'id',
                            'value' => '$data->id',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Mes',
                            'name' => 'fecha',
                            'value' => 'Util::FormatDate($data->fecha,"M")',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Cantidad',
                            'name' => 'cantidad',
                            'value' => '$data->cantidad',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Estado',
                            'name' => 'estado',
                            'value' => '$data->estado',
                            'type' => 'raw',
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i></button>',
                                    'options' => array('title' => 'Realizar deposito'),
                                    'url' => '"pagos/deposito/create?id_pago=".$data->id',
                                    'click' => 'function(e){e.preventDefault(); viewModal($(this).attr("href"),function() {maskAttributes();}); return false;   }',
                                    'imageUrl' => false,
                                ),
                            ),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>