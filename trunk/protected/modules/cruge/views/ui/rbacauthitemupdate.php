<?php
/* $model:  es una instancia que implementa a CrugeAuthItemEditor */
$this->pageTitle = Yii::t('app', 'Roles y Asignaciones');
?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-key"></i> <?php echo ucwords(CrugeTranslator::t("editando")." ".CrugeTranslator::t($model->categoria));?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body">
        <?php $this->renderPartial('_authitemform',array('model'=>$model),false);?>
    </div>
</div>