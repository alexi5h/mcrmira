<?php

Yii::import('ahorro.models._base.BaseAhorroExtra');

class AhorroExtra extends BaseAhorroExtra
{
    /**
     * @return AhorroExtra
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AhorroExtra|AhorroExtras', $n);
    }

}