<script>
    var $cliente_id =<?php echo $id ?>;
</script>
<div style="min-width: <?php echo count($etapas) * 278 ?>px" class="clearfix">
    <?php foreach ($etapas as $etapa): ?>
        <div class="kanban-stage">
            <div class="kanban-title"><?php echo $etapa->nombre; ?></div>
            <ul class="kanban-body" cont-id="<?php echo $etapa->id; ?>">
                <?php
                if (in_array($id, array_map('AweHtml::getPrimaryKey', $etapa->creditos))) :
                    ?>
                    <?php $credito = Credito::model()->findByPk($id); ?>
                    <li class="kanban-item" data-id="<?php echo $credito->id ?>">
<!--                        <div class="kanban-item-title">
                            <?php
//                            echo CHtml::link($credito->fecha_credito, "");
//                            echo CHtml::link($cliente->nombre_formato, "", array("id" => $cliente->id, "onClick" => "viewModal('incidencias/incidencia/view/id/" . $cliente->id . "')"));
                            ?>
                        </div>-->
                        <div><label>Nombre socio: </label> <?php echo $credito->socio->nombre_formato; ?></div>
                        <div><label>Cantidad total: </label> <?php echo '$'.$credito->cantidad_total; ?></div>
                        <div><label>Fecha crédito: </label> <?php echo $credito->fecha_credito; ?></div>
                        <div><label>Fecha límite: </label> <?php echo $credito->fecha_limite; ?></div>
                        <div >
                            <?php
//                            $this->widget(
//                                    'ext.bootstrap.widgets.TbToggleButton', array(
//                                'name' => 'testToggleButtonB',
//                                'enabledLabel' => 'Aprobado',
//                                'disabledLabel' => 'En espera...',
//                                'value' => $cliente->aprobado,
//                                'onChange' => 'js:function($el, status, e){ actualizarAprobado($cliente_id,status);}',
//                                'width' => 200,
//                                'enabledStyle' => 'success',
//                                    )
//                            );
                            ?>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>