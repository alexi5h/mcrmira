<?php

Yii::import('credito.models._base.BaseCredito');

class Credito extends BaseCredito
{
    /**
     * @return Credito
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Credito|Creditos', $n);
    }

}