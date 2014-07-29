<?php 
	/* maneja la asignacion masiva de usuarios a un rol seleccionado. */
    $this->pageTitle = Yii::t('app', 'Roles y Asignaciones');

	$rbac = Yii::app()->user->rbac;
	$ui = Yii::app()->user->ui;
	Yii::app()->clientScript->registerCoreScript('jquery');
	$loaderSrc = Yii::app()->user->ui->getResource('loading.gif');
	$loaderImg = "<img src='{$loaderSrc}'>";

	$selectedUserGetter = 'userdescription';
?>

<div class="widget blue">
    <div class="widget-title">
        <h4><i class="icon-key"></i> <?php echo ucfirst(CrugeTranslator::t("Roles Disponibles"));?></h4>
        <span class="tools">
            <a href="javascript:;" class="icon-chevron-down"></a>
            <!--a href="javascript:;" class="icon-remove"></a-->
        </span>
     </div>
    <div class="widget-body form">
        <div class='crugepanel user-assignments-role-list'>
            <p><?php echo ucfirst(CrugeTranslator::t("Haz click en un rol para ver los usuarios asignados a el"));?></p>
            <ul class='auth-item'>
            <?php 
                $loader = "<span class='loader'></span>";
                foreach($rbac->roles as $rol){
                    echo "<li alt='".$rol->name."' class='btn'>".$rol->name.$loader."</li>";
                }
            ?>
            </ul>
        </div>


        <div class='crugepanel user-assignments-detail'>
            <div class='separator-form span11' id='mostrarSeleccion'></div>
            <div class="clear"></div>

            <div id='lista1' class='lista'>
            <div id='revocarSeleccion' class='btn btn-danger'>
                <i class="icon-lock"></i> <?php echo CrugeTranslator::t("revocar seleccion") ?>
            </div>
            <?php 
                    $this->widget(Yii::app()->user->ui->CGridViewClass, array(
                            'id'=>'_lista1',
                            'selectableRows'=>2,
                            'dataProvider'=>$roleUsersDataProvider,
                            'columns'=>array(
                                    array(
                                            'class'=>'CCheckBoxColumn'
                                    ),
                                    $selectedUserGetter,
                            )
                    ));
            ?>	
            </div>
            <div id='lista2' class='lista'>
            <div id='asignarSeleccion' class='btn btn-success'>
                <i class="icon-unlock"></i> <?php echo CrugeTranslator::t("asignar seleccion") ?>
            </div>
            <?php 
                    $this->widget(Yii::app()->user->ui->CGridViewClass, array(
                            'id'=>'_lista2',
                            'selectableRows'=>2,
                            'dataProvider'=>$allUsersDataProvider,
                            'columns'=>array(
                                    array(
                                            'class'=>'CCheckBoxColumn'
                                    ),
                                    $selectedUserGetter,
                            ),
                    ));
            ?>	
            </div>
        </div>
    </div>
</div>

<script>
	<?php /* a cada LI del div de roles le anexa un evento click y le pone un cursor */ ?>
	
	var _setSelectedItemName = function(valor){
		$('#mostrarSeleccion').html(valor);
		$('#mostrarSeleccion').data("itemName",valor);
	}
	var _getSelectedItemName = function(){
		return $('#mostrarSeleccion').data("itemName")+"";
	}
	var _isSelectedItemName = function(){
		return _getSelectedItemName() != 'undefined';
	}
	$('.user-assignments-role-list ul').find('li').each(function(){
		var li = $(this);
		li.css("cursor","pointer");
		li.click(function(){
			var itemName = $(this).attr('alt');
			_setSelectedItemName("");
			$('.user-assignments-role-list ul').find('li').each(function(){
				$(this).removeClass('selected');
			});
			$(this).addClass('selected');
			_setSelectedItemName(itemName);
			// actualiza la lista1, que contiene los usuarios que tienen la asignacion	
			$.fn.yiiGridView.update('_lista1',{ data : "itemName="+itemName+"&mode=select" });
		});
	});
	
	$('#asignarSeleccion').css("cursor","pointer");
	$('#asignarSeleccion').click(function(){
		if(!_isSelectedItemName())return;
		var itemName = _getSelectedItemName();
		var selectedUsers = $.fn.yiiGridView.getSelection('_lista2');
		if(((selectedUsers == 'undefined') || (selectedUsers==""))==false){
			$.fn.yiiGridView.update('_lista1',
				{ data : "itemName="+itemName+"&userid="+selectedUsers+"&mode=assign" });
		}
	});

	$('#revocarSeleccion').css("cursor","pointer");
	$('#revocarSeleccion').click(function(){
		if(!_isSelectedItemName())return;
		var itemName = _getSelectedItemName();
		var selectedUsers = $.fn.yiiGridView.getSelection('_lista1');
		if(((selectedUsers == 'undefined') || (selectedUsers==""))==false){
			$.fn.yiiGridView.update('_lista1',
				{ data : "itemName="+itemName+"&userid="+selectedUsers+"&mode=revoke" });
		}
	});
</script>

