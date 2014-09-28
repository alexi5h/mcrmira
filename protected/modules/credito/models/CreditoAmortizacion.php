<?php

Yii::import('credito.models._base.BaseCreditoAmortizacion');

class CreditoAmortizacion extends BaseCreditoAmortizacion {

    //    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';

    /**
     * @return CreditoAmortizacion
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'CreditoAmortizacion|CreditoAmortizacions', $n);
    }

    public function scopes() {
        return array(
            'en_deuda' => array(
                'condition' => 't.estado = :estado',
                'params' => array(
                    ':estado' => self::ESTADO_DEUDA,
                ),
            ),
        );
    }

    public function de_credito($credito_id) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 't.credito_id = :credito_id',
                    'order' => 't.nro_cuota ASC',
                    'params' => array(
                        ':credito_id' => $credito_id
                    ),
                )
        );
        return $this;
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nro_cuota', $this->nro_cuota);
        $criteria->compare('fecha_pago', $this->fecha_pago, true);
        $criteria->compare('cuota', $this->cuota, true);
        $criteria->compare('interes', $this->interes, true);
        $criteria->compare('amortizacion', $this->amortizacion, true);
        $criteria->compare('mora', $this->mora, true);
        $criteria->compare('estado', $this->estado, true);
        $criteria->compare('saldo_contra', $this->saldo_contra, true);
        $criteria->compare('saldo_favor', $this->saldo_favor, true);
        $criteria->compare('credito_id', $this->credito_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 7,
            ),
        ));
    }

}
