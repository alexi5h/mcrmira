<div class="widget red">
    <div class="widget-title">
        <h4> <i class="icon-dollar"></i> <?php echo CreditoDeposito::label(2) ?> </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <div style="overflow: auto">
            <?php
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id' => 'credito-deposito-grid',
                'type' => 'striped bordered hover advance',
                'dataProvider' => new CArrayDataProvider($model->creditoDepositos),
                'columns' => array(
                    array(
                        'header' => "Cantidad",
                        'name' => 'cantidad',
                        'value' => 'number_format($data->cantidad, 2)',
                    ),
                    array(
                        'header' => "Entidad Bancaria",
                        'name' => 'entidad_bancaria_id',
                        'value' => '$data->entidadBancaria->nombre',
                    ),
                    array(
                        'header' => 'Fecha Comprobante',
                        'value' => 'Util::FormatDate($data->fecha_comprobante_entidad, "d/m/Y")',
                    ),
                ),
            ));
            ?>
            <br>
            <?php
            if ($model->saldo_contra > 0) {
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type' => 'default',
                    'icon' => 'plus',
                    'label' => 'Agregar Depósito',
                    'htmlOptions' => array(
//                        'href' => 'ahorro/ahorroDeposito/create?id_ahorro=' . $model->id,
                        'onClick' => 'js:viewModalWidth("credito/creditoDeposito/create?credito_id=' . $model->id . '",function() {maskAttributes();}); ',
                    ),
                ));
            }
            ?>
        </div>
    </div>
</div>