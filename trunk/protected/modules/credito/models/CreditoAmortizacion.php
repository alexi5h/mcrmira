<?php

Yii::import('credito.models._base.BaseCreditoAmortizacion');

class CreditoAmortizacion extends BaseCreditoAmortizacion
{
    /**
     * @return CreditoAmortizacion
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'CreditoAmortizacion|CreditoAmortizacions', $n);
    }

}