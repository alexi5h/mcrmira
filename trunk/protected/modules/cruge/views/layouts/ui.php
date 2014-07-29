<?php
/*
  aqui: $this->beginContent('//layouts/main'); indica que este layout se amolda
  al layout que se haya definido para todo el sistema, y dentro de el colocara
  su propio layout para amoldar a un CPortlet.

  esto es para asegurar que el sistema disponga de un portlet,
  esto es casi lo mismo que haber puesto en UiController::layout = '//layouts/column2'
  a diferencia que aqui se indica el uso de un archivo CSS para estilos predefinidos

  Yii::app()->layout asegura que estemos insertando este contenido en el layout que
  se ha definido para el sistema principal.
 */
?>
<?php
$this->beginContent('//layouts/column2');
?>

<?php
if (Yii::app()->user->isSuperAdmin) {
    echo Yii::app()->user->ui->superAdminNote();
}
?>
    <div class="top-controlls">
        <?php foreach(Yii::app()->user->ui->tradeAdminItems as $menu) :?>
        <?php $this->widget(
            'bootstrap.widgets.TbButtonGroup',
            array(
                'buttons' => array($menu),
            )
        ); ?>
        <?php endforeach; ?>
    </div>

    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
    <?php if (Yii::app()->user->checkAccess('admin')) { ?>	
<?php } ?>

<?php $this->endContent(); ?>