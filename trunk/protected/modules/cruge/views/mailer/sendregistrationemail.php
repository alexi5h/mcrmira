<h2>Activacion de su cuenta</h2>
<p>Gracias por registrarse en el sistema de incidencias de <?php echo Yii::app()->name ?>, 
   por seguridad antes de continuar debe activar su cuenta.</p>
<h3>Active su cuenta haciendo click en el siguiente enlace:</h3>
<p><?php echo CHtml::link(Yii::app()->user->um->getActivationUrl($model), Yii::app()->user->um->getActivationUrl($model)); ?>
</p>

