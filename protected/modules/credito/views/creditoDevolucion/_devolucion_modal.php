<?php
Util::tsRegisterAssetJs('_devolucion_modal.js');
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><i class="icon-tasks"></i> <?php echo ' ' . Yii::t('AweCrud.app', 'View') . ' de ' . CreditoDevolucion::label(); ?></h4>
</div>

<script>
    var devolucion_id = "<?php echo $model->id; ?>";
</script>

<div class="modal-body">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'nullDisplay' => '',
        'attributes' => array(
            array(
                'label' => 'Socio',
                'value' => $model->creditoDeposito->credito->socio->nombre_formato,
            ),
            array(
                'label' => 'Número Cheque',
                'value' => CHtml::link($model->creditoDeposito->credito->numero_cheque, Yii::app()->createUrl("credito/credito/view", array("id" => $model->creditoDeposito->credito->id))),
                'type' => 'raw',
            ),
            array(
                'name' => 'cantidad',
                'value' => "$" . number_format($model->cantidad, 2)
            ),
            array(
                'label' => 'Fecha depósito',
                'value' => Util::FormatDate($model->creditoDeposito->fecha_comprobante_su, "d/m/Y")
            ),
        ),
    ));
    ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'primary',
        'icon' => 'ok',
        'label' => 'Registrar devolución',
        'encodeLabel' => false,
//        'id' => 'edit-' . date('U'),
        'htmlOptions' => array(
            'onClick' => 'save();',
        ),
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Cerrar',
        'icon' => 'remove',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
</div>
