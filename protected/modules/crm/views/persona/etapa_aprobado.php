<div class="widget red">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Clientes en Etapa 2 y Aprobados</h4>
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
                    'id' => 'persona-etapa-activo-grid',
//                        'afterAjaxUpdate' => "function(id,data){AjaxActualizarActividades();}",
                    'type' => 'striped bordered hover advance',
                    'dataProvider' => $c_activos_data,
                    'columns' => array(
                        'cedula',
                        //'ruc',
                        'telefono',
                        'celular',
                        'email',
                        'aprobado',
                        
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php //var_dump($model->etapa_activos()) ?>