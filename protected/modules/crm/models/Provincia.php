<?php

Yii::import('crm.models._base.BaseProvincia');

class Provincia extends BaseProvincia
{
    /**
     * @return Provincia
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Provincia|Provincias', $n);
    }

}