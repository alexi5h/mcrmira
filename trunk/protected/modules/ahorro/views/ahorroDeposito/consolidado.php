<?php Util::tsRegisterAssetJs('consolidado.js'); ?>
<div class="widget blue">
    <div class="widget-title">
        <h4>
            <i class="icon-money"></i> Consolidado
        </h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
    </div>
    <div class="widget-body">
        <div style="overflow: auto;">
            <?php
            $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                'fixedHeader' => true,
                'headerOffset' => 40,
//                'responsiveTable' => true,
                'id' => 'consolidado-grid',
                'type' => 'striped bordered hover advance',
                'template' => '{items}',
                'dataProvider' => new CArrayDataProvider($data, array('pagination' => false)),
                'columns' => array(
                    array(
                        'value' => '$data["id"]',
                        'type' => 'raw',
                        'header' => 'Num'
                    ),
                    array(
                        'value' => '$data["Nombres"]',
                        'type' => 'raw',
                        'header' => 'Nombres'
                    ),
                    array(
                        'value' => '$data["Cedula"]',
                        'type' => 'raw',
                        'header' => 'Cedula'
                    ),
                    array(
                        'value' => '$data["Saldo"]',
                        'type' => 'raw',
                        'header' => 'Saldo',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Enero"]',
                        'type' => 'raw',
                        'header' => 'Ene',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Febrero"]',
                        'type' => 'raw',
                        'header' => 'Feb',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Marzo"]',
                        'type' => 'raw',
                        'header' => 'Mar',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Abril"]',
                        'type' => 'raw',
                        'header' => 'Abr',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Mayo"]',
                        'type' => 'raw',
                        'header' => 'May',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Junio"]',
                        'type' => 'raw',
                        'header' => 'Jun',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Julio"]',
                        'type' => 'raw',
                        'header' => 'Jul',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Agosto"]',
                        'type' => 'raw',
                        'header' => 'Ago',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Septiembre"]',
                        'type' => 'raw',
                        'header' => 'Sep',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Octubre"]',
                        'type' => 'raw',
                        'header' => 'Oct',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Noviembre"]',
                        'type' => 'raw',
                        'header' => 'Nov',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Diciembre"]',
                        'type' => 'raw',
                        'header' => 'Dic',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                    array(
                        'value' => '$data["Total"]',
                        'type' => 'raw',
                        'header' => 'Total',
                        'class' => 'bootstrap.widgets.TbTotalSumColumn'

                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
