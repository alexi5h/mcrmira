<?php
/** @var EntradaController $this */
/** @var Entrada $model */
$this->pageTitle = "Importar Archivo CSV";

?>
<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-upload-alt"></i> Importar Archivo CSV</h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body" id="formulario">
        <?php echo $this->renderPartial('_form_importar', array('model' => $model)); ?>
    </div>
</div>