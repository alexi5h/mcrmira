<?php

Yii::import('pagos.models._base.BaseDeposito');

class Deposito extends BaseDeposito
{
    /**
     * @return Deposito
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Deposito|Depositos', $n);
    }

}