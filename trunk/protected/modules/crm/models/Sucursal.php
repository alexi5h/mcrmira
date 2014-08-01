<?php

Yii::import('crm.models._base.BaseSucursal');

class Sucursal extends BaseSucursal {

    public $provincia_id;
    public $canton_id;

    /**
     * @return Sucursal
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Sucursal|Sucursals', $n);
    }

    public function rules() {
        return array(
            array('direccion_id,provincia_id,canton_id,nombre', 'required'),
            array('provincia_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'No hay Provincias.',
            ),
            array('canton_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'No hay Cantones.',
            ),
            array('direccion_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 45),
            array('nombre', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, nombre, direccion_id', 'safe', 'on' => 'search'),
        );
    }

}
