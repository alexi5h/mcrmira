<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Util::tsRegisterAssetJs('kanban.js');
//$this->pageTitle = Incidencia::label(2);

$this->menu = array(
    array('label' => Yii::t('AweCrud.app', 'Create'), 'icon' => 'plus',  'url' => array('create')),
    array('label' => Yii::t('AweCrud.app', 'lista'), 'icon' => 'list-alt',  'url' => array('admin')),
);
?>
<div class="row-fluid">
    <div class="widget green">
        <div class="widget-title">
            <h4><i class="icon-trello"></i> Gesti&oacute;n Etapa</h4>
        </div>
        <div class="widget-body">

            <div id="KambanIncidencia" class="kanban-container clearfix">
                <?php $this->renderPartial('_kanban', array('etapas' => $etapas)); ?>
            </div>

        </div>
    </div>
</div>