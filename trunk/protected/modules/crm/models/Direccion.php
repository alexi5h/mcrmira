<?php

Yii::import('crm.models._base.BaseDireccion');

class Direccion extends BaseDireccion
{
    /**
     * @return Direccion
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Direccion|Direccions', $n);
    }

}