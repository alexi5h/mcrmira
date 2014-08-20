<?php

Yii::import('crm.models._base.BasePersona');
Yii::import('ahorro.models.*');

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
        return Yii::t('app', 'Socio|Socios', $n);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'nombre_formato' => Yii::t('app', 'Nombre Completo'),
                )
        );
    }

    public function rules() {
        return array(
            array('cedula', 'ext.Validations.CampoCedula'),
            array('ruc', 'ext.Validations.CampoRucCedula', 'compareAttribute' => 'cedula', 'operator' => '=='),
            array('ruc', 'ext.Validations.CampoRuc'),
            array('nombre_formato', 'safe', 'on' => 'search'),
            array('primer_nombre, apellido_paterno, cedula, usuario_creacion_id, sucursal_id, persona_etapa_id', 'required'),
            array('usuario_creacion_id, usuario_actualizacion_id, aprobado, sucursal_id, persona_etapa_id, direccion_domicilio_id, direccion_negocio_id, cedula, ruc', 'numerical', 'integerOnly' => true),
            array('email', 'email'),
            array('primer_nombre, segundo_nombre', 'length', 'max' => 20),
            array('apellido_paterno, apellido_materno', 'length', 'max' => 30),
            array('telefono, celular', 'length', 'max' => 10),
            array('email', 'length', 'max' => 255),
            array('tipo', 'length', 'max' => 7),
            array('estado', 'length', 'max' => 8),
            array('descripcion, fecha_actualizacion', 'safe'),
            array('tipo', 'in', 'range' => array('CLIENTE', 'GARANTE')), // enum,
            array('estado', 'in', 'range' => array('ACTIVO', 'INACTIVO')), // enum,
            array('segundo_nombre, apellido_materno, ruc, telefono, celular, email, descripcion, tipo, estado, fecha_actualizacion, usuario_actualizacion_id, aprobado, direccion_domicilio_id, direccion_negocio_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, cedula, ruc, telefono, celular, email, descripcion, tipo, estado, fecha_creacion, fecha_actualizacion, usuario_creacion_id, usuario_actualizacion_id, aprobado, sucursal_id, persona_etapa_id, direccion_domicilio_id, direccion_negocio_id', 'safe', 'on' => 'search'),
//                )
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
        $criteria->compare('CONCAT(t.primer_nombre, IFNULL(CONCAT(" ",t.segundo_nombre),""), CONCAT(" ",t.apellido_paterno), IFNULL(CONCAT(" ",t.apellido_materno),""))', $this->nombre_formato, true, 'OR');
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

    public function etapa_activos() {
        $c_activos = Yii::app()->db->createCommand()
                ->select('*')
                ->from('persona p')
                ->join('persona_etapa e', 'p.persona_etapa_id=e.id')
                ->where(array('and', 'e.id=3', 'p.aprobado=0'))
                ->queryAll();
        //return $c_activos;
        $c_activos_data = new CArrayDataProvider($c_activos, array(
            'keyField' => 'id',
            'pagination' => array('pageSize' => 30,)
        ));
        return $c_activos_data;
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
        $this->nombre_formato = $return;
        return $this->nombre_formato;
    }

    public function setNombre_formato($nombre_formato) {
        $this->nombre_formato = $nombre_formato;
        return $this->nombre_formato;
    }

    public function getNombre_corto() {
        $return = $this->primer_nombre . ' ' . $this->apellido_paterno;
        return $return;
    }

}
