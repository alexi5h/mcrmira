<?php

Yii::import('crm.models.*');

//Yii::import('cobranzas.models.*');

class ImportForm extends CFormModel {

    public $csv_file;
    public $tipo_entidad;

    const TIPO_ENTIDAD_SOCIO = 1;
    
    /* Cuentas=0
     * Contacto=1
     */

//    public $contacto;

    public function rules() {
        return array(
            array('csv_file,tipo_entidad', 'required'),
            array('csv_file', 'file', 'types' => 'csv'),
        );
    }

    public function attributeLabels() {
        return array(
            'csv_file' => Yii::t('app', 'Archivo CSV'),
        );
    }

}
