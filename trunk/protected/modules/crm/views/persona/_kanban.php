<div style="min-width: <?php echo count($etapas) * 278 ?>px" class="clearfix">
    <?php foreach ($etapas as $etapa): ?>
        <div class="kanban-stage">
            <div class="kanban-title"><?php echo $etapa->nombre; ?></div>
            <ul class="kanban-body" cont-id="<?php echo $etapa->id; ?>">
                <?php
                foreach (Persona::model()->activos()->de_etapa($etapa->id)->findAll() as $incidencia):
                    ?>
                    <li class="kanban-item" data-id="<?php echo $incidencia->id ?>">
                        <div class="kanban-item-title"><?php
                            echo CHtml::link($incidencia->primer_nombre, "", array("id" => $incidencia->id, "onClick" => "viewModal('incidencias/incidencia/view/id/" . $incidencia->id . "')"));
                            ?></div>
                        <!-- Contacto -->
                        <div><label>Responsable:</label> <?php echo $incidencia->nombre_formato; // echo $oportunidad['monto'];           ?></div>
                        <!-- fecha estima de solucion -->
                        <?php // if ($incidencia->fecha_est_resolucion): ?>
                        <!--<div>-->
                            <!--<label>Fecha Estimada:</label> <?php // echo "<span class=\"label label-mini " . Util::nicetimeColor($incidencia->fecha_est_resolucion) . " \">" . Util::nicetime($incidencia->fecha_est_resolucion) . "</span>"  ?></div>-->
                        <?php // endif; ?>
                        <div>

                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>