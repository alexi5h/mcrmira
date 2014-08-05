<?php

Yii::import('crm.models._base.BasePersona');

class Persona extends BasePersona {

    //estado: ACTIVO,INACTIVO
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
    //tipo: CLIENTE,GARANTE
    const TIPO_CLIENTE = 'CLIENTE';
    const TIPO_GARANTE = 'GARANTE';
    
    public static $origen='';

    private $nombre_formato;
    private $nombre_corto;

    /**
     * @return Persona
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Persona|Personas', $n);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'nombre_formato' => Yii::t('app', 'Nombre Completo'),
                )
        );
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

    public function de_tipo($tipo) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'tipo = :tipo',
                    'params' => array(
                        ':tipo' => $tipo
                    ),
                )
        );
        return $this;
    }

    public function getNombre_formato() {
        $return = $this->primer_nombre;
        $return = $return . ($this->segundo_nombre ? ' ' . $this->segundo_nombre : '');
        $return = $return . ' ' . $this->apellido_paterno;
        $return = $return . ($this->apellido_materno ? ' ' . $this->apellido_materno : '');
        return $return;
    }

    public function getNombre_corto() {
        $return = $this->primer_nombre . ' ' . $this->apellido_paterno;
        return $return;
    }
    
    public function cambioEstado($orig) {
        static::$origen=$orig;
        return $orig;
    }
    
    public function mostrarOrigen() {
        return static::$origen;
    }
    
    public function getOrigen() {
        return static::$origen;
    }

}
