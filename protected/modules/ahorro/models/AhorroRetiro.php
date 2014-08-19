<?php

Yii::import('ahorro.models._base.BaseAhorroRetiro');

class AhorroRetiro extends BaseAhorroRetiro
{
    /**
     * @return AhorroRetiro
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AhorroRetiro|AhorroRetiros', $n);
    }

}