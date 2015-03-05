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
        return Yii::t('app', 'Sucursal|Sucursales', $n);
    }

    public function rules() {
        return array(
            array('nombre, direccion_id, estado, valor_inscripcion, valor_ahorro', 'required'),
            array('valor_inscripcion, valor_ahorro', 'numerical'),
            array('direccion_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 45),
            array('estado', 'length', 'max' => 8),
            array('estado', 'in', 'range' => array('ACTIVO', 'INACTIVO')), // enum,
            array('id, nombre, direccion_id, estado, valor_inscripcion, valor_ahorro', 'safe', 'on' => 'search'),
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

    public function getListSelect2($search_value = null) {
        $command = Yii::app()->db->createCommand()
                ->select("p.id as id, p.nombre as text")
                ->from('sucursal p')
                ->where('p.estado = :estado', array(':estado' => self::ESTADO_ACTIVO));
        if ($search_value) {
            $command->where("p.nombre like '$search_value%'");
        }
        $command->limit(10);
        return $command->queryAll();
    }

}
