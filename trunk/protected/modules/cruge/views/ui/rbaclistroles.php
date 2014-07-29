<?php
$this->pageTitle = Yii::t('app', 'Roles y Asignaciones');
?>



<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-key"></i> <?php echo ucwords(CrugeTranslator::t("roles"));?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body">
        <div class="row-fluid">
            <div class='span12'>
            <?php echo CHtml::link('<i class="icon-plus icon-white"></i> '.CrugeTranslator::t("Crear Nuevo Rol")
                    ,Yii::app()->user->ui->getRbacAuthItemCreateUrl(CAuthItem::TYPE_ROLE),
                    array('class'=>'btn btn-success pull-right'));?>
            </div>
        </div>
        
        <?php $this->renderPartial('_listauthitems',array('dataProvider'=>$dataProvider),false);?>
    </div>
</div>