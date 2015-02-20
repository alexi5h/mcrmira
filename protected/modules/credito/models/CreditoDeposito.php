<?php

Yii::import('credito.models._base.BaseCreditoDeposito');

class CreditoDeposito extends BaseCreditoDeposito {

    /**
     * @return CreditoDeposito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Depósito de Crédito|Depósitos de Crédito', $n);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'entidadBancaria' => array(self::BELONGS_TO, 'EntidadBancaria', 'entidad_bancaria_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_comprobante_id'),
        ));
    }

    public function searchByCredito($credito_id) {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
        $criteria->compare('credito_id', $credito_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }

    public function beforeSave() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeValidate();
    }

    public function searchDepositosSocio($socio_id = null) {
        $criteria = new CDbCriteria;
        $sort = new CSort;
        $criteria->with = array('credito');
        $criteria->addCondition('credito.socio_id=:socio_id', 'AND');
//        $criteria->addCondition('t.id not in (select ev.cuenta_id from evento_visita ev where ev.estado=:ev_estado)', 'AND');
//        $criteria->addCondition('(t.frecuencia is not null OR t.frecuencia>0)', 'AND');

        $params = array(
            ':socio_id' => $socio_id,
        );
        $criteria->params = array_merge($criteria->params, $params);
        /* Sort criteria */

        $sort->attributes = array(
            'fecha_comprobante_su' => array(
                'asc' => 't.fecha_comprobante_su asc',
                'desc' => 't.fecha_comprobante_su desc',
            ),
            '*',
        );
        $sort->defaultOrder = 't.fecha_comprobante_su asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, 'sort' => $sort,
        ));
    }

    public function generarCodigoComprobante($socio_id = '') {
        $result = date('y') . date('m') . date('d') . date('H') . date('i') . date('s') . $socio_id;
        return $result;
    }

}
