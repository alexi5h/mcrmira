<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Util::tsRegisterAssetJs('kanban.js');
//$this->pageTitle = Incidencia::label(2);

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Atras'), 'icon' => 'icon-arrow-left', 'url' => array('view', 'id' => $id)),
);
?>
<div class="row-fluid">
    <div class="widget green">
        <div class="widget-title">
            <h4><i class="icon-trello"></i> Gesti&oacute;n Etapa</h4>
        </div>
        <div class="widget-body">

            <div id="KambanIncidencia" class="kanban-container clearfix">
                <?php $this->renderPartial('_kanban', array('etapas' => $etapas, 'id' => $id)); ?>
            </div>

        </div>
    </div>
</div>