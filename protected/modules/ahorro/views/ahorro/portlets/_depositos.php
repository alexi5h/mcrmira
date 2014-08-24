<?php ?>
<?php ?>

<div class="widget red">
    <div class="widget-title">
        <h4> <i class="icon-dollar"></i> <?php echo AhorroDeposito::label() ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'ahorro-deposito-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => new CArrayDataProvider($model->ahorroDepositos),
            'columns' => array(
                'cantidad',
                array(
                    'name' => 'entidad_bancaria_id',
                    'value' => '$data->entidadBancaria->nombre',
                ),
//                'cod_comprobante_entidad',
                'fecha_comprobante_entidad',
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
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{update} ',
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
//                        'delete' => array(
//                            'label' => '<button class="btn btn-danger"><i class="icon-trash"></i></button>',
//                            'options' => array('title' => 'Eliminar'),
//                            'imageUrl' => false,
//                        //'visible' => 'Util::checkAccess(array("action_incidenciaPrioridad_delete"))'
//                        ),
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