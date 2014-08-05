<div class="search-form">
    <?php
    /** @var CuentaController $this */
    /** @var AweActiveForm $form */
    Yii::app()->clientScript->registerScript('search' . $this->id, "
    $('#" . $this->nameInput . "').keyup(function(){
//        $('#" . $this->grid_id . "').attr('class','grid-view-loading');
        $.fn.yiiGridView.update('" . $this->grid_id . "',{
            data:$('#" . $this->id . "').serialize(),
            complete:function(jqXHR, status) {
                    if (status=='success'){
                        console.log('completo');
                    }
                },
            beforeSend:function() {
//                var settings= $.fn.yiiGridView.gridSettings['" . $this->grid_id . "'];
//                    $('#" . $this->grid_id . "').addClass(settings.loadingClass);
                    console.log('enviado');
                },
            
          });
    });
    $('#" . $this->idList . "').click(function(){
        if ($('#" . $this->idList . " input:checked').length > 0) {
            console.log($('#" . $this->idList . " input:checked').val()+' " . $this->id . "');
            $.fn.yiiGridView.update('" . $this->grid_id . "', {
                data: $('#" . $this->id . "').serialize()
            });
        }
    });
    ");
//    $('#searchTruulo >div.truulo-search>div.btn-group > button> i').attr('class','icon-loading')
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => $this->id
    ));
    ?>

    <div class="truulo-search">
        <div class="btn-group">
            <button class="btn display-truulo-search-options">
                <i class="icon-search"></i>
                <span class="caret"></span>
            </button>
            <ul class="truulo-search-options" id="<?php echo $this->idList; ?>">
                <li><input type="checkbox" name="search[filters][]" value="all" class="all" checked="checked" /> <?php echo Yii::t('app', 'Todo') ?></li>

                <?php if ($this->modulo == "campaniaOperador"): ?>
                    <?php foreach ($this->model->searchParams(true) as $param): ?>
                        <li><input type="checkbox" name="search[filters][]" value="<?php echo $param ?>" /> <?php echo $this->model->getAttributeLabel($param) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($this->model->searchParams() as $param): ?>
                        <li><input type="checkbox" name="search[filters][]" value="<?php echo $param ?>" /> <?php echo $this->model->getAttributeLabel($param) ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <input class="span12 search_value" id="<?php echo $this->nameInput ?>" name="search[value]" type="text" autocomplete="off">
    </div>
    <?php $this->endWidget(); ?>
</div>