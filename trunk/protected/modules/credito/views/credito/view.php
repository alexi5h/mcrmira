<?php
Util::tsRegisterAssetJs('view.js');
/** @var CreditoController $this */
/** @var Credito $model */
?>

<div class="row-fluid">
    <div class="span12">
        <h1 class="name-title"><i class="icon-money"></i> <?php echo Util::number_pad($model->id,5) ?></h1>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <?php $this->renderPartial('portlets/_info', array('model' => $model)) ?>
    </div>

    <div class="span6">
        <?php $this->renderPartial('portlets/_depositos', array('model' => $model)); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <?php $this->renderPartial('portlets/_amortizacion', array('model' => $model)) ?>
    </div>
</div>