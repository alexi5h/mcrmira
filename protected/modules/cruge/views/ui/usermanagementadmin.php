<?php
/** @var FormController $this */
/** @var Form $model */

$this->pageTitle = Yii::t('app', 'Administrador de Usuarios');
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-user"></i> <?php echo ucwords(CrugeTranslator::t('admin', 'Manage Users')); ?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body form">
        <?php
        /*
          para darle los atributos al CGridView de forma de ser consistente con el sistema Cruge
          es mejor preguntarle al Factory por los atributos disponibles, esto es porque si se decide
          cambiar la clase de CrugeStoredUser por otra entonces asi no haya dependenci directa a los
          campos.
         */
        $cols = array();

    // presenta los campos de ICrugeStoredUser
        foreach (Yii::app()->user->um->getSortFieldNamesForICrugeStoredUser() as $key => $fieldName) {
            $value = null; // default
            $filter = null; // default, textbox
            $type = 'text';
            if ($fieldName == 'state') {
                $value = '$data->getStateName()';
                $filter = Yii::app()->user->um->getUserStateOptions();
            }
            if ($fieldName == 'logondate') {
                $type = 'datetime';
            }
            if ($fieldName != 'iduser') {
                $cols[] = array('name' => $fieldName, 'value' => $value, 'filter' => $filter, 'type' => $type);
            }
        }

        $cols[] = array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
            'deleteConfirmation' => CrugeTranslator::t('admin', 'Are you sure you want to delete this user'),
            'buttons' => array(
                'update' => array(
                    'label'=>'<button class="btn btn-primary"><i class="icon-pencil"></i></button>',
                    'options'=>array('title'=>CrugeTranslator::t('admin', 'Update User')),
                    'url' => 'array("usermanagementupdate","id"=>$data->getPrimaryKey())',
                    'imageUrl'=>false,
                ),
            ),
        );
        $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'llamada-grid',
            'type' => 'striped condensed',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => $cols
        ));
        ?>
        
    </div>
</div>