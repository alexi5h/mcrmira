<?php

Yii::import('pago.models._base.BasePagoMes');

class PagoMes extends BasePagoMes
{
    /**
     * @return PagoMes
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'PagoMes|PagoMes', $n);
    }

}