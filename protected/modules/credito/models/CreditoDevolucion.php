<?php

Yii::import('credito.models._base.BaseCreditoDevolucion');

class CreditoDevolucion extends BaseCreditoDevolucion {

    const ESTADO_NO_DEVUELTO = 'NO DEVUELTO';
    const ESTADO_DEVUELTO = 'DEVUELTO';

    /**
     * @return CreditoDevolucion
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Devolución Crédito|Devoluciones de Crédito', $n);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'usuario_devolucion_id' => Yii::t('app', 'Usuario Devolución'),
            'fecha_devolucion' => Yii::t('app', 'Fecha Devolución'),
            'credito_deposito_id' => Yii::t('app', 'Credito Depósito'),
        ));
    }

    public function scopes() {
        return array(
            'orden_estado' => array(
                'order' => 't.estado asc',
            ),
        );
    }

}
