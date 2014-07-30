<?php

Yii::import('crm.models._base.BasePersona');

class Persona extends BasePersona
{
    /**
     * @return Persona
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Persona|Personas', $n);
    }

}