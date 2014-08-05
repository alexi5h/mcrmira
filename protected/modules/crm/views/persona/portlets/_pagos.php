<?php
// Obtener contactos activos
$pagos = Pago::model()->de_cliente($model->id)->findAll();
?>

<div class="widget red">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Pagos</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <a href="javascript:;" class="icon-remove"></a>
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
                    'dataProvider' => new CArrayDataProvider($pagos, array('pagination' => array('pageSize' => 5))),
                    'columns' => array(
                        array(
                            'header' => 'Mes',
                            'name'=>'fecha',
                            'value' => 'Util::FormatDate($data->fecha,"M")',
                            'type' => 'raw',
                        ),
                        array(
                            'header'=>'Cantidad',
                            'name' => 'cantidad',
                            'value' => '$data->cantidad',
                            'type' => 'raw',
                        ),
//                            array(
//                                'class' => 'CButtonColumn',
//                                'template' => '{update} {delete}',
//                                'buttons' => array(
//                                    'update' => array(
//                                        'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
//                                        'options' => array('title' => 'Actualizar'),
////                                        'url' => 'Yii::app()->createUrl("tareas/tarea/update", array("id"=>$data->id))',
//                                        'imageUrl' => false,
////                                        'visible' => 'Util::checkAccess(array("action_tarea_update"))'
//                                    ),
//                                    'delete' => array(
//                                        'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                                        'options' => array('title' => 'Eliminar'),
////                                        'url' => 'Yii::app()->createUrl("tareas/tarea/delete", array("id"=>$data->id))',
//                                        'imageUrl' => false,
////                                        'visible' => 'Util::checkAccess(array("action_tarea_delete"))',
//                                    ),
//                                ),
//                                'htmlOptions' => array(
//                                    'width' => '140px'
//                                )
//                            ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>