<?php

Yii::import('crm.models._base.BaseEntidadBancaria');

class EntidadBancaria extends BaseEntidadBancaria
{
    /**
     * @return EntidadBancaria
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'EntidadBancaria|EntidadBancarias', $n);
    }

}