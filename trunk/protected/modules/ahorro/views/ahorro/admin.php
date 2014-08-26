<?php
/** @var AhorroController $this */
/** @var Ahorro $model */
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create') . ' ' . Ahorro::label(1), 'icon' => 'plus', 'url' => array('create'),
    //'visible' => (Util::checkAccess(array('action_incidenciaPrioridad_create')))
    ),
);
?>
<div id="flashMsg"  class="flash-messages">

</div> 
<div class="widget blue">
    <div class="widget-title">
        <h4> <i class="icon-money"></i> <?php echo Yii::t('AweCrud.app', 'Manage') ?> <?php echo Ahorro::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">

        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'ahorro-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->search(),
            'columns' => array(
                
                  array(
                        'name' => 'Id',
                        'value' => 'CHtml::link($data->id, Yii::app()->createUrl("ahorro/ahorro/view",array("id"=>$data->id)))',
                        'type' => 'raw',
                    ),
                array(
                    'name' => 'socio_id',
                    'value' => '$data->socio->nombre_formato'
                ),
                'cantidad',
                'fecha',
                array(
                    'name' => 'estado',
                    'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                ),
                array(
                    'name' => 'tipo',
                    'filter' => array('OBLIGATORIO' => 'OBLIGATORIO','VOLUNTARIO' => 'VOLUNTARIO','PRIMER_PAGO' => 'PRIMER_PAGO',),
                ),
                'saldo_contra',
                /*
                  'saldo_favor',
                  'saldo_extra',
                  array(
                  'name' => 'anulado',
                  'value' => '($data->anulado === 0) ? Yii::t(\'AweCrud.app\', \'No\') : Yii::t(\'AweCrud.app\', \'Yes\')',
                  'filter' => array('0' => Yii::t('AweCrud.app', 'No'), '1' => Yii::t('AweCrud.app', 'Yes')),
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