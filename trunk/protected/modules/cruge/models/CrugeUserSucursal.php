<?php

Yii::import('cruge.models._base.BaseCrugeUserSucursal');

class CrugeUserSucursal extends BaseCrugeUserSucursal
{
    /**
     * @return CrugeUserSucursal
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'CrugeUserSucursal|CrugeUserSucursals', $n);
    }

}