<?php
$ahorros = new AhorroExtra;
?>
<div class="widget orange">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Ahorros Extras</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
        </span>
    </div>
    <div class="widget-body">
        <div style='overflow:auto'> 
            <?php
            $this->widget('ext.bootstrap.widgets.TbGridView', array(
                'id' => 'ahorro-extra-grid',
//                        'afterAjaxUpdate' => "function(id,data){AjaxActualizarActividades();}",
                'type' => 'striped bordered hover advance',
                'dataProvider' => $ahorros->de_socio($model->id)->search(),
                'columns' => array(
                    array(
                        'header' => 'Fecha',
                        'name' => 'fecha_creacion',
                        'value' => 'Util::FormatDate($data->fecha_creacion,"d/m/Y")',
                        'type' => 'raw',
                    ),
                    array(
                        'header' => 'Cantidad',
                        'name' => 'cantidad',
                        'value' => '$data->cantidad',
                        'type' => 'raw',
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>