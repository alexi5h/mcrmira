<?php

Yii::import('crm.models._base.BaseBarrio');

class Barrio extends BaseBarrio
{
    /**
     * @return Barrio
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Barrio|Barrios', $n);
    }

}