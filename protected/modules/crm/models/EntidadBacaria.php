<?php

Yii::import('crm.models._base.BaseEntidadBacaria');

class EntidadBacaria extends BaseEntidadBacaria
{
    /**
     * @return EntidadBacaria
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'EntidadBacaria|EntidadBacarias', $n);
    }

}