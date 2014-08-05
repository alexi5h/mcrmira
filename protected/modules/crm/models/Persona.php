<?php

Yii::import('crm.models._base.BasePersona');

class Persona extends BasePersona {

    //estado: ACTIVO,INACTIVO
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
    //tipo: CLIENTE,GARANTE
    const TIPO_CLIENTE = 'CLIENTE';
    const TIPO_GARANTE = 'GARANTE';

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

    public function searchParams() {
        return array(
            'nombre_formato',
            'cedula',
            'telefono',
            'celular',
            'email',
            'sucursal_id',
            'persona_etapa_id',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('sucursal', 'personaEtapa');


//        $criteria->compare('t.id', $this->id, true, 'OR');
//        $criteria->compare('primer_nombre', $this->primer_nombre, true,'OR');
//        $criteria->compare('segundo_nombre', $this->segundo_nombre, true,'OR');
//        $criteria->compare('apellido_paterno', $this->apellido_paterno, true,'OR');
//        $criteria->compare('apellido_materno', $this->apellido_materno, true,'OR');
        $criteria->compare('CONCAT(t.primer_nombre,IFNULL(CONCAT(" ",t.segundo_nombre),""),CONCAT(" ",t.apellido_paterno),""),IFNULL(CONCAT(" ",t.apellido_materno),""))', $this->nombre_formato, true, 'OR');
        $criteria->compare('t.cedula', $this->cedula, true, 'OR');
//        $criteria->compare('ruc', $this->ruc, true);
        $criteria->compare('t.telefono', $this->telefono, true, 'OR');
        $criteria->compare('t.celular', $this->celular, true, 'OR');
        $criteria->compare('t.email', $this->email, true, 'OR');
//        $criteria->compare('descripcion', $this->descripcion, true,'OR');
//        $criteria->compare('tipo', $this->tipo, true,'OR');
//        $criteria->compare('estado', $this->estado, true,'OR');
//        $criteria->compare('fecha_creacion', $this->fecha_creacion, true,'OR');
//        $criteria->compare('fecha_actualizacion', $this->fecha_actualizacion, true,'OR');
//        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
//        $criteria->compare('usuario_actualizacion_id', $this->usuario_actualizacion_id);
//        $criteria->compare('aprobado', $this->aprobado);
        $criteria->compare('sucursal.nombre', $this->sucursal_id, true, 'OR');
        $criteria->compare('personaEtapa.nombre', $this->persona_etapa_id, true, 'OR');
//        $criteria->compare('direccion_domicilio_id', $this->direccion_domicilio_id);
//        $criteria->compare('direccion_negocio_id', $this->direccion_negocio_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

    public function de_etapa($etapa_id) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'persona_etapa_id = :persona_etapa_id',
                    'params' => array(
                        ':persona_etapa_id' => $etapa_id
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

}
