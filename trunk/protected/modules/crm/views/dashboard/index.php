<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
//Total de contactos
?>

<h1>Bienvenido al Demo de <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<div class="metro-nav">

    <div class="metro-nav-block nav-block-orange double">
        <a href="<?php echo Yii::app()->createUrl('/crm/persona/admin') ?>" data-original-title="">
            <i class="icon-briefcase"></i>
            <div class="info"><?php echo count(Persona::model()->activos()->findAll()) ?></div>
            <div class="status">Nº de Socios</div>
        </a>
    </div>

    <div class="metro-nav-block nav-block-purple">
        <a href="<?php echo Yii::app()->createUrl('/credito/credito/admin') ?>" data-original-title="">
            <i class="icon-shopping-cart"></i>
            <div class="info"><?php echo count(Credito::model()->findAll()) ?></div>
            <div class="status">Creditos</div>
        </a>
    </div>
    <div class="metro-nav-block nav-block-green">
        <a href="<?php echo Yii::app()->createUrl('/ahorro/ahorroRetiro/admin') ?>" data-original-title="">
            <i class="icon-dollar"></i>
            <div class="info"><?php echo count(AhorroRetiro::model()->findAll()) ?></div>
            <div class="status">Retiros</div>
        </a>
    </div>

</div>
