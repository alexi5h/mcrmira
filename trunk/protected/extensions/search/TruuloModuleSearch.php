<?php

class TruuloModuleSearch extends CWidget {

    public $model;
    public $route;
    public $grid_id;
    public $id = 'searchTruulo';
    public $nameInput = 'inputSearh';
    public $idList = 'ConditionList';
    public $searchParams = null;
    public $modulo;

    public function init() {
        // Create route
        if (!$this->route) {
            if ($this->controller->module)
                $this->route .= $this->controller->module->id . '/';
            $this->route .= $this->controller->id . '/';
            $this->route .= $this->controller->action->id;
        }
        if ($this->searchParams == null) {
            $this->searchParams = $this->model->searchParams();
        }

        // Add css and js
        $this->publishAssets();
    }

    public function publishAssets() {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        Yii::app()->clientScript->registerCssFile($baseUrl . '/css/truulo-search.css');
        if ($this->idList != 'ConditionList') {
            Yii::app()->clientScript->registerScript('list' . $this->idList, $this->attr());
        } else {
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/truulo-search.js');
        }
    }

    public function run() {
        $this->render('truuloModuleSearch');
    }

    public function attr() {
        return "$('.display-truulo-search-options').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).next('#" . $this->idList . "').toggle();
    });
    
    $('#" . $this->idList . "').click(function(e) {
        e.stopPropagation();
    });
    
    $('html').click(function() {
        $(this).parent().find('#" . $this->idList . "').hide();
    });
    
    $('#" . $this->idList . " input.all').click(function(){
        if($(this).is(':checked')) {
            $('#" . $this->idList . " input').each(function(){
                $(this).not('.all').removeAttr('checked');
            });
        } else {
            return false;
        }
        
    });
    
    $('#" . $this->idList . " input').not('.all').click(function(){
        if ($('#" . $this->idList . " input:checked').length == 0) {
            $('#" . $this->idList . " input.all').trigger('click');
            $('#" . $this->idList . " input.all').attr('checked', 'checked');
        } else {
            $('#" . $this->idList . " input.all').removeAttr('checked');
        }
    });";
    }

}
