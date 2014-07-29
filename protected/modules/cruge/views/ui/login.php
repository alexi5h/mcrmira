<?php if(Yii::app()->user->hasFlash('loginflash')): ?>
<div class="alert alert-error">
    <?php echo Yii::app()->user->getFlash('loginflash'); ?>
</div>
<?php else: ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'logon-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<div class="metro single-size red">
    <div class="locked">
        <i class="icon-lock"></i>
    </div>
</div>
<div class="metro double-size green">
    <div class="input-append lock-input">
        <?php echo $form->textField($model,'username', array('placeholder'=>CrugeTranslator::t('logon', 'Username'))); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>
</div>
<div class="metro double-size yellow">
    <div class="input-append lock-input">
        <?php echo $form->passwordField($model,'password', array('placeholder'=>Yii::t('app',CrugeTranslator::t('logon', "Password")))); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
</div>
<div class="metro single-size terques login">
    <button type="submit" class="btn login-btn">
        <?php echo CrugeTranslator::t('logon', "Login") ?>
        <i class=" icon-long-arrow-right"></i>
    </button>
</div>

<div class="login-footer">
    <div class="remember-hint pull-left">
        <?php echo $form->checkBox($model,'rememberMe'); ?> Recordarme más tarde
    </div>
    <div class="forgot-hint pull-right">
        <?php echo Yii::app()->user->ui->passwordRecoveryLink; ?>
    </div>
</div>


<?php
    /*if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
            echo Yii::app()->user->ui->registrationLink;*/
?>
<?php
        //	si el componente CrugeConnector existe lo usa:
        //
        if(Yii::app()->getComponent('crugeconnector') != null){
        if(Yii::app()->crugeconnector->hasEnabledClients){ 
?>
<div class='crugeconnector'>
        <span><?php echo CrugeTranslator::t('logon', 'You also can login with');?>:</span>
        <ul>
        <?php 
                $cc = Yii::app()->crugeconnector;
                foreach($cc->enabledClients as $key=>$config){
                        $image = CHtml::image($cc->getClientDefaultImage($key));
                        echo "<li>".CHtml::link($image,
                                $cc->getClientLoginUrl($key))."</li>";
                }
        ?>
        </ul>
</div>
<?php }} ?>
	

<?php $this->endWidget(); ?>
<?php endif; ?>
