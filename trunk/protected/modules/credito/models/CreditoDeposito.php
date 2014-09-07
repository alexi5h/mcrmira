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
        return Yii::t('app', 'CreditoDeposito|CreditoDepositos', $n);
    }

}