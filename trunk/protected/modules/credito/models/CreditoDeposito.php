<?php

Yii::import('credito.models._base.BaseCreditoDeposito');

class CreditoDeposito extends BaseCreditoDeposito
{
    /**
     * @return CreditoDeposito
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Depósito de Crédito|Depósitos de Crédito', $n);
    }

    public function searchByCredito($credito_id)
    {
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


    public function beforeSave()
    {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeValidate();
    }


}