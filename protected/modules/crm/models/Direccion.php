<?php

Yii::import('crm.models._base.BaseDireccion');

class Direccion extends BaseDireccion {

    public $provincia_id;
    public $canton_id;

    /**
     * @return Direccion
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Direccion|Direccions', $n);
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('provincia_id,canton_id,parroquia', 'required'),
        ));
    }

}
