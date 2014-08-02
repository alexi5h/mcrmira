<?php

Yii::import('crm.models._base.BaseSucursal');

class Sucursal extends BaseSucursal {

    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';

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
            array('nombre, estado', 'required'),
            array('direccion_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 45),
            array('estado', 'length', 'max' => 8),
            array('estado', 'in', 'range' => array('ACTIVO', 'INACTIVO')), // enum,
            array('id, nombre, direccion_id, estado', 'safe', 'on' => 'search'),
        );
    }

    public function scopes() {
        return array(
            'activos' => array(
                'condition' => 't.estado = :estado',
                'params' => array(
                    ':estado' => self::ESTADO_ACTIVO,
                ),
            ),
        );
    }

}
