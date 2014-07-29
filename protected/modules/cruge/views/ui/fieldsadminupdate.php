
<?php
/* $model:  es una instancia que implementa a ICrugeField */

$this->pageTitle = Yii::t('app', 'Campos Personalizados');
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-list"></i> <?php echo ucwords(CrugeTranslator::t(	
		(($model->isNewRecord==1) ? "creando nuevo campo personalizado" :"editando campo personalizado")
	));?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'crugefield-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
        )); ?>
        <div class="row-fluid form-group">
                <div class='separator-form span11'><?php echo ucfirst(CrugeTranslator::t("datos del campo"));?></div>
                <div class="clear"></div>
                <div class='col control-group'>
                        <?php echo $form->labelEx($model,'fieldname'); ?>
                        <?php echo $form->textField($model,'fieldname',array('size'=>15,'maxlength'=>20)); ?>
                        <?php echo $form->error($model,'fieldname'); ?>
                </div>
                <div class='col control-group'>
                        <?php echo $form->labelEx($model,'longname'); ?>
                        <?php echo $form->textField($model,'longname'); ?>
                        <?php echo $form->error($model,'longname'); ?>
                </div>
                <div class='col control-group'>
                        <?php echo $form->labelEx($model,'position'); ?>
                        <?php echo $form->textField($model,'position',array('size'=>5,'maxlength'=>3)); ?>
                        <?php echo $form->error($model,'position'); ?>
                </div>
                <div class='col control-group'>
                        <?php echo $form->labelEx($model,'required'); ?>
                        <?php echo $form->checkBox($model,'required'); ?>
                        <?php echo $form->error($model,'required'); ?>
                </div>
                <div class='col control-group'>
                        <?php echo $form->labelEx($model,'showinreports'); ?>
                        <?php echo $form->checkBox($model,'showinreports'); ?>
                        <?php echo $form->error($model,'showinreports'); ?>
                </div>
        </div>

        <div class="row-fluid form-group">
                <div class='separator-form span11'><?php echo ucfirst(CrugeTranslator::t("datos del contenido"));?></div>
                <div class="clear"></div>
                <div class="field-group">
                        <div class='col control-group'>
                                <?php echo $form->labelEx($model,'fieldtype'); ?>
                                <?php echo $form->dropDownList($model,'fieldtype'
                                        ,Yii::app()->user->um->getFieldTypeOptions()); ?>
                                <?php echo $form->error($model,'fieldtype'); ?>
                        </div>
                        <div class='col control-group'>
                                <?php echo $form->labelEx($model,'fieldsize'); ?>
                                <?php echo $form->textField($model,'fieldsize',array('size'=>5,'maxlength'=>3)); ?>
                                <?php echo $form->error($model,'fieldsize'); ?>
                        </div>
                        <div class='col control-group'>
                                <?php echo $form->labelEx($model,'maxlength'); ?>
                                <?php echo $form->textField($model,'maxlength',array('size'=>5,'maxlength'=>5)); ?>
                                <?php echo $form->error($model,'maxlength'); ?>
                        </div>
                </div>

                <div class="field-group">
                        <div class='col control-group'>
                                <?php echo $form->labelEx($model,'predetvalue'); ?>
                                <?php echo $form->textArea($model,'predetvalue',array('rows'=>5,'cols'=>40)); ?>
                                <?php echo $form->error($model,'predetvalue'); ?>
                                <p class='hint'><?php echo CrugeTranslator::t(
        "si el fieldtype es un Listbox ponga aqui las opciones una por cada linea,
         el valor coloquelo al inicio seguido de una coma, ejemplo:
         <ul style='list-style: none;'>
         <li>1, azul</li>
         <li>2, rojo</li>
         <li>3, verde</li>
         </ul>
        "
        );?></p>
                        </div>
                </div>
        </div>

        <!--<div class="row-fluid form-group">
                <div class='separator-form span11'><?php echo ucfirst(CrugeTranslator::t("datos de validacion"));?></div>
                <div class="clear"></div>
                <div class='field-group'>
                        <div class='row-fluid'>
                                <?php echo $form->labelEx($model,'useregexp'); ?>
                                <?php echo $form->textArea($model,'useregexp',array('rows'=>5,'cols'=>40)); ?>
                                <?php echo $form->error($model,'useregexp'); ?>
                                <p class='hint'><?php echo CrugeTranslator::t("dejar en blanco si no se quiere usar");?></p>
                        </div>
                        <?php echo ucfirst(CrugeTranslator::t(
                                        "La expresion regular (regexp) es una lista de caracteres
                                         que validan la sintaxis de lo que el usuario ingrese en este campo.
                                         por ejemplo:"
                                ));
                        ?>
                        <?php
                        echo "<br/><u>".CrugeTranslator::t("telefono:")."</u><br/>^([0-9-.+ \(\)]{3,20})$";
                        echo "<br/><u>".CrugeTranslator::t("digitos y letras:")."</u><br/>^([a-zA-Z0-9]+)$";
                        ?>
                </div>
                <div class='row-fluid'>
                        <?php echo $form->labelEx($model,'useregexpmsg'); ?>
                        <?php echo $form->textField($model,'useregexpmsg',array('size'=>50,'maxlength'=>512)); ?>
                        <?php echo $form->error($model,'useregexpmsg'); ?>
                </div>
        </div>-->



        <div class="form-actions">
            <div class="form-actions-float">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'success',
                'icon'=>'ok',
                'label' => CrugeTranslator::t(($model->isNewRecord ? "Crear Campo" : "Actualizar Campo")),
            )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'icon'=>'remove',
                'label' => Yii::t('AweCrud.app', 'Cancel'),
                'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
            )); ?>
            </div>
        </div>
        <?php echo $form->errorSummary($model); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>