<?php

Yii::import('ahorro.models._base.BaseAhorro');

class Ahorro extends BaseAhorro
{
    /**
     * @return Ahorro
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Ahorro|Ahorros', $n);
    }

}