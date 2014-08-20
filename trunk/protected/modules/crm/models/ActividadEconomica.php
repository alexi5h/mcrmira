<?php

Yii::import('crm.models._base.BaseActividadEconomica');

class ActividadEconomica extends BaseActividadEconomica
{
    /**
     * @return ActividadEconomica
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Actividad Económica|Actividades Económicas', $n);
    }

}