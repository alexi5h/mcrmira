<?php
$this->pageTitle = Yii::t('app', 'Roles y Asignaciones');
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-key"></i> <?php echo ucwords(CrugeTranslator::t("operaciones"));?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body">
        <?php
            $ar = array(
                    '4'=>CrugeTranslator::t('Ver Todo'),
                    '1'=>CrugeTranslator::t('Módulos'),
                    '2'=>CrugeTranslator::t('Usuarios'),
                    //'3'=>CrugeTranslator::t('Controladoras'),
            );
        ?>
        <div class="row-fluid">
            <div class='span12'>
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn dropdown-toggle"><?php echo CrugeTranslator::t("Filtrar") ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <?php
                        foreach($ar as $filter=>$text)
                                echo "<li>".CHtml::link($text, array('/cruge/ui/rbaclistops', 'filter'=>$filter))."</li>";
                        ?>
                    </ul>
                </div>
            <?php echo CHtml::link('<i class="icon-plus icon-white"></i> '.CrugeTranslator::t("Crear Nueva Operacion")
            ,Yii::app()->user->ui->getRbacAuthItemCreateUrl(CAuthItem::TYPE_OPERATION),
                        array('class'=>'btn btn-success pull-right'));?>
            </div>
        </div>

        <?php $this->renderPartial('_listauthitems'
                ,array('dataProvider'=>$dataProvider)
                ,false
                );?>
    </div>
</div>