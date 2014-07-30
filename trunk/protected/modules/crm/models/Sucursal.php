<?php

Yii::import('crm.models._base.BaseSucursal');

class Sucursal extends BaseSucursal
{
    /**
     * @return Sucursal
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Sucursal|Sucursals', $n);
    }

}