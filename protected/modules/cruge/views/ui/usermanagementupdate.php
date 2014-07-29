<?php
/** @var Form $model es una instancia que implementa a ICrugeStoredUser, y debe traer ya los campos extra 	accesibles desde $model->getFields() */
/** @var Boolean $boolIsUserManagement true o false.  si es true indica que esta operandose bajo el action de adminstracion de usuarios, si es false indica que se esta operando bajo 'editar tu perfil' */

$this->pageTitle = Yii::t('app', 'Administrador de Usuarios');
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-user"></i> <?php echo ucwords(CrugeTranslator::t($boolIsUserManagement ? "editando usuario" : "editando tu perfil"));?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body form">
        <?php $form = $this->beginWidget('ext.AweCrud.components.AweActiveForm', array(
            'id'=>'crugestoreduser-form',
            'type' => 'horizontal',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
        )); ?>
        
        <?php echo $form->textFieldRow($model, 'username', array('class'=>'span4')) ?>
        <?php echo $form->textFieldRow($model, 'email', array('class'=>'span4')) ?>
        <?php echo $form->textFieldRow($model, 'newPassword', array(
                'class'=>'span12',
                'append'=>CHtml::ajaxLink(
                    "<i class='icon-refresh'></i>"
                    ,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
                    ,array('success'=>'js:fnSuccess','error'=>'js:fnError')
                    
                )
        )) ?>
        <script>
            function fnSuccess(data){
                $('#CrugeStoredUser_newPassword').val(data);
            }
            function fnError(e){
                alert("error: "+e.responseText);
            }
        </script>
        
        <div class="row-fluid form-group">
            <div class='field-group'>
                <div class='col control-group textfield-readonly'>
                    <?php echo $form->labelEx($model,'regdate'); ?>
                    <?php echo $form->textField($model,'regdate',array(
                            'readonly'=>'readonly',
                            'value'=>Yii::app()->user->ui->formatDate($model->regdate),
                        )); ?>
                </div>
                <div class='col control-group textfield-readonly'>
                    <?php echo $form->labelEx($model,'actdate'); ?>
                    <?php echo $form->textField($model,'actdate',array(
                            'readonly'=>'readonly',
                            'value'=>Yii::app()->user->ui->formatDate($model->actdate),
                        )); ?>
                </div>
                <div class='col control-group textfield-readonly'>
                <?php echo $form->labelEx($model,'logondate'); ?>
                <?php echo $form->textField($model,'logondate',array(
                        'readonly'=>'readonly',
                        'value'=>Yii::app()->user->ui->formatDate($model->logondate),
                    )
                ); ?>
                </div>
            </div>
        </div>

        <!-- inicio de campos extra definidos por el administrador del sistema -->
        <?php 
        if(count($model->getFields()) > 0){
            echo "<div class='row-fluid form-group'>";
            echo "<div class='separator-form span11'>".ucfirst(CrugeTranslator::t("datos de la cuenta"))."</div>";
            echo '<div class="clear"></div>';
            foreach($model->getFields() as $f){
                // aqui $f es una instancia que implementa a: ICrugeField
                echo "<div class='col control-group'>";
                echo Yii::app()->user->um->getLabelField($f);
                echo Yii::app()->user->um->getInputField($model,$f);
                echo $form->error($model,$f->fieldname);
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
        <!-- fin de campos extra definidos por el administrador del sistema -->




        <!-- inicio de opciones avanazadas, solo accesible bajo el rol 'admin' -->

        <?php 
                if($boolIsUserManagement){
                    if(Yii::app()->user->checkAccess('edit-advanced-profile-features'
                        ,__FILE__." linea ".__LINE__)){
                        $this->renderPartial('_edit-advanced-profile-features'
                                ,array('model'=>$model,'form'=>$form),false);
                    }		 
                }

        ?>

        <!-- fin de opciones avanazadas, solo accesible bajo el rol 'admin' -->
        
        <div class="form-actions">
            <div class="form-actions-float">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'success',
                'icon'=>'ok',
                'label' => CrugeTranslator::t("Guardar"),
            )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'icon'=>'remove',
                'label' => Yii::t('AweCrud.app', 'Cancel'),
                'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
            )); ?>
            </div>
        </div>
        
        <?php //echo $form->errorSummary($model); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>