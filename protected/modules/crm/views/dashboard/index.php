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
            <div class="status">Creditos Otorgados</div>
        </a>
    </div>
    <div class="metro-nav-block nav-block-green">
        <a href="<?php echo Yii::app()->createUrl('/ahorro/ahorroRetiro/admin') ?>" data-original-title="">
            <i class="icon-dollar"></i>
            <div class="info"><?php echo count(AhorroRetiro::model()->findAll()) ?></div>
            <div class="status">Retiros Realizados</div>
        </a>
    </div>
    <div class="metro-nav-block nav-block-yellow">
        <a href="<?php // echo Yii::app()->createUrl('/ahorro/ahorroRetiro/admin')        ?>" data-original-title="">
            <i class="icon-money"></i>
            <div class="info"><?php echo '$' . Ahorro::model()->getTotalAhorros_Obligatorios_y_Primer_Pago() ?></div>
            <div class="status">Depositos</div>
        </a>
    </div>
    <div class="metro-nav-block nav-block-red">
        <a href="<?php // echo Yii::app()->createUrl('/ahorro/ahorroRetiro/admin')        ?>" data-original-title="">
            <i class="icon-money"></i>
            <div class="info"><?php echo '$' . Ahorro::model()->getTotalAhorros_Voluntarios() ?></div>
            <div class="status">Ahorros Voluntarios</div>
        </a>
    </div>

</div>
<div class="metro-nav">

<!--    <div class="metro-nav-block nav-block-redblack double">
        <a href="<?php // echo Yii::app()->createUrl('/crm/persona/admin')  ?>" data-original-title="">
            <i class="icon-money"></i>
            <div class="info"><?php // echo '$' . Ahorro::model()->getTotalAhorros_extras() ?></div>
            <div class="status">Ahorros Extras</div>
        </a>
    </div>-->

    <div class="metro-nav-block nav-block-grey">
        <a href="<?php // echo Yii::app()->createUrl('/credito/credito/admin')  ?>" data-original-title="">
            <i class="icon-shopping-cart"></i>
            <div class="info"><?php echo '$' . Credito::model()->getTotalCreditos() ?></div>
            <div class="status">Cr&eacute;ditos</div>
        </a>
    </div>
    <div class="metro-nav-block nav-block-blue">
        <a href="<?php // echo Yii::app()->createUrl('/credito/credito/admin')  ?>" data-original-title="">
            <i class="icon-money"></i>
            <div class="info"><?php echo '$' . Ahorro::model()->getTotalAhorros_Deuda() ?></div>
            <div class="status">Ahorro Deudas</div>
        </a>
    </div>
    <div class="metro-nav-block nav-block-orange">
        <a href="<?php // echo Yii::app()->createUrl('/credito/credito/admin')  ?>" data-original-title="">
            <i class="icon-shopping-cart"></i>
            <div class="info"><?php echo '$' .  Credito::model()->getTotalCreditosDeuda() ?></div>
            <div class="status">Cr&eacute;ditos Deudas</div>
        </a>
    </div>


</div>
