<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app()->name;
//Total de contactos
?>

<h1>Bienvenido al Demo de <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>


<div class="metro-nav ">
    <div class="metro-nav-block nav-block-orange">
        <a href="<?php echo Yii::app()->createUrl('/crm/persona/admin') ?>" data-original-title="">
            <i class="icon-briefcase"></i>
            <div class="info"><?php echo count(Persona::model()->activos()->findAll()) ?></div>
            <div class="status">Nº de Socios</div>
        </a>
    </div>
</div>