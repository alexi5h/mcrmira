<?php

Yii::import('crm.models._base.BasePersona');

class Persona extends BasePersona {

    //estado: ACTIVO,INACTIVO
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
    //tipo: CLIENTE,GARANTE
    const TIPO_CLIENTE = 'CLIENTE';
    const TIPO_GARANTE = 'GARANTE';

    /**
     * @return Persona
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Persona|Personas', $n);
    }

}
