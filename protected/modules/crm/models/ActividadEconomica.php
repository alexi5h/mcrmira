<?php

Yii::import('crm.models._base.BaseActividadEconomica');

class ActividadEconomica extends BaseActividadEconomica
{
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
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
    
    public function rules() {
        return array_merge(parent::rules(), array(
            array('nombre, estado', 'required'),
            array('nombre', 'unique','on'=>'create'),
        ));
    }
    
    public function scopes() {
        return array(
            'activos' => array(
                'condition' => 't.estado = :estado',
                'params' => array(
                    ':estado' => self::ESTADO_ACTIVO,
                ),
            ),
        );
    }

}