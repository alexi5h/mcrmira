<?php
/** @var AhorroController $this */
/** @var Ahorro $model */
Util::tsRegisterAssetJs('admin.js');
$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Registrar') . ' ' . Ahorro::label(1), 'icon' => 'plus', 'url' => array('create'),
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
        </span>
    </div>
    <div class="widget-body">

        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'ahorro-grid',
            'type' => 'striped bordered hover advance',
            'dataProvider' => $model->de_tipo(Ahorro::TIPO_OBLIGATORIO)->search(),
            'columns' => array(
                array(
                    'header' => 'Código',
                    'name' => 'Id',
                    'value' => 'CHtml::link(Util::number_pad($data->id,5), Yii::app()->createUrl("ahorro/ahorro/view",array("id"=>$data->id)))',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'socio_id',
                    'value' => 'CHtml::link($data->socio->nombre_formato, Yii::app()->createUrl("crm/persona/view",array("id"=>$data->socio->id)))',
                    'type' => 'raw',
                ),
                'cantidad',
                array(
                    'name' => 'fecha',
                    'value' => 'Util::FormatDate($data->fecha,"d/m/Y")',
                ),
                array(
                    'name' => 'estado',
                    'filter' => array('DEUDA' => 'DEUDA', 'PAGADO' => 'PAGADO',),
                ),
                array(
                    'name' => 'tipo',
                    'filter' => array('OBLIGATORIO' => 'OBLIGATORIO', 'VOLUNTARIO' => 'VOLUNTARIO', 'PRIMER_PAGO' => 'PRIMER_PAGO',),
                ),
                'saldo_contra',
                
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{pago}',
                    'afterDelete' => 'function(link,success,data){ 
                    if(success) {
                         $("#flashMsg").empty();
                         $("#flashMsg").css("display","");
                         $("#flashMsg").html(data).animate({opacity: 1.0}, 5500).fadeOut("slow");
                    }
                    }',
                    'buttons' => array(
                        'pago' => array(
                            'label' => '<button class="btn btn-primary"><i class="icon-dollar"></i></button>',
                            'options' => array('title' => 'Realizar deposito'),
                            'url' => '"ahorro/ahorroDeposito/create?id_ahorro=".$data->id',
                            'click' => 'function(e){e.preventDefault(); viewModalWidth($(this).attr("href"),function() {maskAttributes();});  return false; }',
                            'imageUrl' => false,
                            'visible' => '($data->saldo_contra==0)||($data->estado=="PAGADO")?false:true',
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