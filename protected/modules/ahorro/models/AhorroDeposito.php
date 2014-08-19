<?php

Yii::import('ahorro.models._base.BaseAhorroDeposito');

class AhorroDeposito extends BaseAhorroDeposito
{
    /**
     * @return AhorroDeposito
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AhorroDeposito|AhorroDepositos', $n);
    }

}