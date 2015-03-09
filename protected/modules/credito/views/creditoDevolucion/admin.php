<?php
/** @var CreditoDevolucionController $this */
/** @var CreditoDevolucion $model */
//$this->menu = array(
//    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus', 'url' => array('create'),
//    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
//    ),
//);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-share-alt"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo CreditoDevolucion::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'credito-devolucion-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->orden_estado()->search(),
            'columns' => array(
                array(
                    'header' => 'Numero Cheque',
                    'value' => 'CHtml::link($data->creditoDeposito->credito->numero_cheque, Yii::app()->createUrl("credito/credito/view",array("id"=>$data->creditoDeposito->credito->id)))',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'Socio',
                    'value' => '$data->creditoDeposito->credito->socio->nombre_formato',
                ),
                array(
                    'name' => 'cantidad',
                    'value' => '"$".number_format($data->cantidad,2)'
                ),
                array(
                    'name' => 'estado',
                    'filter' => array('NO DEVUELTO' => 'NO DEVUELTO', 'DEVUELTO' => 'DEVUELTO',),
                ),
                array(
                    'header' => 'Fecha depósito',
                    'value' => 'Util::FormatDate($data->creditoDeposito->fecha_comprobante_su,"d/m/Y")'
                ),
//                'usuario_devolucion_id',
                'fecha_devolucion',
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{devolver}',
                    'afterDelete' => 'function(link,success,data){ 
                    if(success) {
                         $("#flashMsg").empty();
                         $("#flashMsg").css("display","");
                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
                    }
                    }',
                    'buttons' => array(
                        'devolver' => array(
                            'label' => '<button class="btn btn-warning"><i class="icon-dollar"></i></button>',
                            'options' => array('title' => 'Realizar devolución'),
                            'url' => '"credito/creditoDevolucion/devolucion?id=".$data->id',
                            'click' => 'function(e){e.preventDefault(); viewModal($(this).attr("href"),function() {maskAttributes();});  return false; }',
                            'imageUrl' => false,
                            'visible' => '($data->estado=="DEVUELTO")?false:true',
                        ),
//                        'delete' => array(
//                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                            'options' => array('title' => 'Eliminar'),
//                            'imageUrl' => false,
//                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
//                        ),
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