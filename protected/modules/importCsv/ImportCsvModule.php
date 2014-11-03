<?php

class ImportCsvModule extends CWebModule {
    /*
     * direccion donde se van a guardar los archivos csv
     */
    public $path;
    
    /*
     * direccion donde se van a guardar los assets del modulo
     */
    private $_assetsUrl;

    public function init()
    {
        // import the module-level models and components
        $this->setImport(array(
            'importCsv.models.*',
            'importCsv.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            return true;
        }
        else
            return false;
    }
    
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias('application.modules.importCsv.assets')
            );
        return $this->_assetsUrl;
    }
}
