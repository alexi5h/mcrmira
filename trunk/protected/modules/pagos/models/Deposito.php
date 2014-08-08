<?php

Yii::import('pagos.models._base.BaseDeposito');

class Deposito extends BaseDeposito {

    /**
     * @return Deposito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Deposito|Depositos', $n);
    }

    public function searchByPago($id_pago = null) {
        $criteria = new CDbCriteria;
//        $criteria->join = 'inner join pago p on p.id=t.pago_id ';       
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cantidad', $this->cantidad, true);
        $criteria->compare('t.entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('t.cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('t.fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
        $criteria->compare('t.sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('t.cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('t.fecha_comprobante_su', $this->fecha_comprobante_su, true);
//        $criteria->compare('t.pago_id', $this->pago_id, true);
        $criteria->compare('t.pago_id', $id_pago, true);
//        $criteria->compare('p.id', $id_pago, true);
        

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
