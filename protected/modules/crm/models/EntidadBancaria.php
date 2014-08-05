<?php

Yii::import('crm.models._base.BaseEntidadBancaria');
Yii::import('pagos.models.Deposito');

class EntidadBancaria extends BaseEntidadBancaria {

    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';


    /**
     * @return EntidadBancaria
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Entidad Bancaria|Entidades Bancarias', $n);
    }

    public function rules() {
        return array(
            array('nombre, direccion_id, estado', 'required'),
            array('direccion_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 45),
            array('estado', 'length', 'max' => 8),
            array('estado', 'in', 'range' => array('ACTIVO', 'INACTIVO')), // enum,
            array('id, nombre, direccion_id, estado', 'safe', 'on' => 'search'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        
        $criteria->compare('id', $this->id);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('direccion_id', $this->direccion_id);
        $criteria->compare('estado', $this->estado, true);        

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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

    public function relations() {
        return array(
            'direccion' => array(self::BELONGS_TO, 'Direccion', 'direccion_id'),
            'depositos' => array(self::HAS_MANY, 'Deposito', 'entidad_bancaria_id'),
        );
    }

}
