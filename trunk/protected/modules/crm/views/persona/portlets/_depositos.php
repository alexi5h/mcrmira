<?php
$modelDepositoAhorro = new AhorroDeposito;
$modelDepositoCredito = new CreditoDeposito;
$depositosAhorro = $modelDepositoAhorro->searchDepositosSocio($model->id);
$depositosCredito = $modelDepositoCredito->searchDepositosSocio($model->id);
$gridDataProvider = new CArrayDataProvider(array_merge($depositosCredito->getData(), $depositosAhorro->getData()));
$sort = new CSort();
$sort->attributes = array(
    'fecha_comprobante_su' => array(
        'asc' => 'fecha_comprobante_su asc',
        'desc' => 'fecha_comprobante_su desc',
    ),
    'cantidad' => array(
        'asc' => 'cantidad asc',
        'desc' => 'cantidad desc',
    ),
    '*',
);
$sort->defaultOrder = 'fecha_comprobante_su desc';
$gridDataProvider->sort = $sort;
?>
<?php // $validarDataDepositos = count($gridDataProvider->getData()) > 0  ?>
<?php // if ($validarDataDepositos):  ?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-list"></i> Depósitos</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--<a href="javascript:;" class="icon-remove"></a>-->
        </span>
    </div>
    <div class="widget-body">
        <?php
//        $this->widget('ext.search.TruuloModuleSearch', array(
//            'model' => $model,
//            'grid_id' => 'deposito-grid-grid',
//        ));
        ?>
        <div class="row-fluid">
            <div style='overflow:auto'> 
                <?php
                $this->widget('ext.bootstrap.widgets.TbGridView', array(
                    'id' => 'deposito-grid-grid',
                    'type' => '',
                    "template" => "{items}{pager}",
                    'dataProvider' => $gridDataProvider,
                    'columns' => array(
                        array(
                            'header' => 'Cantidad',
                            'name' => 'cantidad',
                            'value' => '$data->cantidad',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Entidad Bancaria',
                            'name' => 'entidad_bancaria_id',
                            'value' => '$data->entidadBancaria->nombre',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Sucursal',
                            'name' => 'sucursal_comprobante_id',
                            'value' => '$data->sucursal->nombre',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Cod. Comprobante',
                            'name' => 'cod_comprobante_su',
                            'value' => '$data->cod_comprobante_su',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Fecha Comprobante Sucursal',
                            'name' => 'fecha_comprobante_su',
                            'value' => '$data->fecha_comprobante_su',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Tipo Depósito',
                            'value' => 'isset($data->ahorro_id) ? "AHORRO" : "CREDITO"',
                            'type' => 'raw',
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// endif; ?>