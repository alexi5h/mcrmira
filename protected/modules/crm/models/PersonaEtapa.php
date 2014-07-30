<?php

Yii::import('crm.models._base.BasePersonaEtapa');

class PersonaEtapa extends BasePersonaEtapa
{
    /**
     * @return PersonaEtapa
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'PersonaEtapa|PersonaEtapas', $n);
    }

}