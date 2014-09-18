<?php
$ahorros = new Ahorro;
?>
<div class="widget red">
    <div class="widget-title">
        <h4><i class="icon-tasks"></i> Ahorros Voluntarios</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
        </span>
    </div>
    <div class="widget-body">
<?php $validarDataPagos = $ahorros->de_socio($model->id)->de_tipo(Ahorro::TIPO_VOLUNTARIO)->count() > 0 ?>
        <?php if ($validarDataPagos): ?>
        


//                        'afterAjaxUpdate' => "function(id,data){AjaxActualizarActividades();}",
                    'type' => 'striped bordered hover advance',
                    'dataProvider' => $ahorros->de_socio($model->id)->de_tipo(Ahorro::TIPO_VOLUNTARIO)->search(),
                    'columns' => array(
                        array(
                            'header' => 'Fecha',
                            'name' => 'fecha',
                            'value' => 'Util::FormatDate($data->fecha,"d/m/Y")',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Cantidad',
                            'name' => 'cantidad',
                            'value' => '$data->cantidad',
                            'type' => 'raw',
                        ),
//                            array(
//                                'header' => 'Pagado',
//                                'name' => 'saldo_favor',
//                                'value' => '$data->saldo_favor',
//                                'type' => 'raw',
//                            ),
//                            array(
//                                'header' => 'Por pagar',
//                                'name' => 'saldo_contra',
//                                'value' => '$data->saldo_contra',
//                                'type' => 'raw',
//                            ),
array(
//                        'header' => 'Razón',
//                        'name' => 'tipo',
//                        'value' => '$data->tipo',
//                        'type' => 'raw',
//                    ),
                    array(
                        'header' => 'Sucursal',
                        'name' => 'ahorro_deposito',
                        'value' => '$data->ahorroDepositoVoluntario->sucursal->nombre',
                        'type' => 'raw',
                    ),
                    array(
                        'header' => 'Entidad Bancaria',
                        'name' => 'ahorro_deposito',
                        'value' => '$data->ahorroDepositoVoluntario->entidadBancaria->nombre',
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}',
                        'buttons' => array(
                            'update' => array(
                                'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i></button>',
                                'options' => array('title' => 'Realizar deposito'),
                                'url' => '"ahorro/ahorroDeposito/create?id_ahorro=".$data->id',
                                'click' => 'function(e){e.preventDefault(); viewModalWidth($(this).attr("href"),function() {maskAttributes();}); return false;}',
                                'imageUrl' => false,
                                'visible' => '($data->estado=="PAGADO")?false:true',
                            ),
                        ),
                    ),
            ));

                echo '<br/>';
                ?>
            </div>
        <?php endif; ?>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'id' => 'agregarAhorroV',
            'label' => $validarDataPagos ? 'Agregar Ahorro Voluntario' : '<h3 >Agregar Ahorro Voluntario</h3>',
            'encodeLabel' => false,
            'icon' => $validarDataPagos ? 'plus-sign' : 'dollar',
            'htmlOptions' => array(
                'onClick' => 'js:viewModal("ahorro/ahorro/ajaxCreateAhorroVoluntario/socio_id/' . $model->id . '",function(){'
                . 'maskAttributes();},true)',
                'class' => $validarDataPagos ? '' : 'empty-portlet',
            ),
        ));
        ?>

    </div>
</div>