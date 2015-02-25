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
                    'name' => 'socio_id',
                    'value' => '$data->socio->nombre_formato'
                ),
                array(
                    'name' => 'garante_id',
                    'value' => '$data->garante->nombre_formato'
                ),
//                array(
//                    'name' => 'sucursal_id',
//                    'value' => '$data->sucursal',
//                    'type' => 'raw',
//                ),
                'fecha_credito',
                'fecha_limite',
                'cantidad_total',
                'total_interes',
                'total_pagar',
//                'interes',
                array(
                    'name' => 'estado',
                    'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                ),
//                array(
//                    'class' => 'CButtonColumn',
//                    'template' => '{stagemanage} {delete}',
//                    'afterDelete' => 'function(link,success,data){ 
//                    if(success) {
//                         $("#flashMsg").empty();
//                         $("#flashMsg").css("display","");
//                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
//                    }
//                    }',
//                    'buttons' => array(
//                        'stagemanage' => array(
//                            'label' => '<button class="btn btn-primary"><i class="icon-tasks"></i> Gestionar Etapa</button>',
//                            'label' => 'CHtml::link(\"<i class=\"icon-tasks\"></i>\", Yii::app()->createUrl("credito/credito/kanban",array("id"=>$data->id)),array("class" => "btn btn-primary","title"=>"Gestionar Etapa"))',
//                            'options' => array(
//                                'title' => 'Gestionar Etapa',
////                                'href'=>$baseUrl.'/credito/credito/kanban?id=$data->id',
//                            ),
//                            'imageUrl' => false,
////                            'url' => '$data->id',
//                        ),
////                        'update' => array(
////                            'label' => '<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
////                            'options' => array('title' => 'Actualizar'),
////                            'imageUrl' => false,
////                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_update"))'
////                        ),
//                        'delete' => array(
//                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                            'options' => array('title' => 'Eliminar'),
//                            'imageUrl' => false,
//                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
//                        ),
//                    ),
//                    'htmlOptions' => array(
//                        'width' => '80px'
//                    )
//                ),
            ),
        ));
        ?>
    </div>
</div>