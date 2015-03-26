<?php

Yii::import('crm.models._base.BasePersona');
Yii::import('ahorro.models.*');

class Persona extends BasePersona
{

    //estado: ACTIVO,INACTIVO
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
    const ESTADO_RETIRADO = 'RETIRADO';
    //tipo: CLIENTE,GARANTE
    const TIPO_NUEVO = 'NUEVO';
//    const TIPO_CLIENTE = 'CLIENTE';
    const TIPO_FUNDADOR = 'FUNDADOR';
//    const TIPO_GARANTE = 'GARANTE';
    //sexo: MASCULINO,FEMENINO
    const SEXO_MASCULINO = 'MASCULINO';
    const SEXO_FEMENINO = 'FEMENINO';
    //discapacidad
    const DISCAPASIDAD_SI = 'SI';
    const DISCAPASIDAD_NO = 'NO';
//estado civil
    const ESTADO_CIVIL_SOLTERO = 'SOLTERO';
    const ESTADO_CIVIL_CASADO = 'CASADO';
    const ESTADO_CIVIL_DIVORCIADO = 'DIVORCIADO';
    const ESTADO_CIVIL_VIUDO = 'VIUDO';

    private $nombre_formato;
    private $cedula_nombre_formato;
    private $nombre_corto;
    public $madre_soltera;
    public $canton_ids;

    /**
     * @return Persona
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Socio|Socios', $n);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
                'nombre_formato' => Yii::t('app', 'Nombre Completo'),
                'actividad_economica_id' => Yii::t('app', 'Actividad Económica'),
                'actividad_economica' => null,
                'cedula' => Yii::t('app', 'Identificación'),
                'sucursal_id' => Yii::t('app', 'Cantón'),
            'fecha_creacion' => Yii::t('app', 'Fecha de registro'),
            )
        );
    }

    public function relations()
    {
        return array_merge(parent::relations(), array(
                'actividad_economica' => array(self::BELONGS_TO, 'ActividadEconomica', 'actividad_economica_id'),
                'ahorros' => array(self::HAS_MANY, 'Ahorro', 'socio_id'),
            )
        );
    }

    public function beforeSave()
    {
        if (!$this->sucursal_id)
            $this->sucursal_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if (!$this->sucursal_id)
            $this->sucursal_id = Util::getSucursal();
        return parent::beforeValidate();
    }

    public function rules()
    {
        return array_merge(parent::rules(), array(
                array('primer_nombre, apellido_paterno, cedula, usuario_creacion_id, sucursal_id', 'required', 'on' => 'import'),
                array('cedula', 'ext.Validations.CampoCedula', 'on' => array('insert', 'update')),
//            array('ruc', 'ext.Validations.CampoRucCedula', 'compareAttribute' => 'cedula', 'operator' => '=='),
                array('ruc', 'ext.Validations.CampoRuc'),
                array('nombre_formato', 'safe', 'on' => 'search'),
//            array('primer_nombre, apellido_paterno, tipo_identificacion, cedula, usuario_creacion_id, sucursal_id, persona_etapa_id, sexo, fecha_nacimiento, carga_familiar, discapacidad, estado_civil, actividad_economica_id', 'required'),
                array('primer_nombre, apellido_paterno, cedula, usuario_creacion_id, sucursal_id, sexo, fecha_nacimiento, carga_familiar, discapacidad, estado_civil, actividad_economica_id', 'required', 'on' => array('insert', 'update')),
                array('usuario_creacion_id, usuario_actualizacion_id, aprobado, sucursal_id, persona_etapa_id, direccion_domicilio_id, direccion_negocio_id, ruc', 'numerical', 'integerOnly' => true),
                array('email', 'email'),
                array('cedula,ruc', 'unique', 'on' => array('insert', 'update', 'import')),
                array('primer_nombre, segundo_nombre', 'length', 'max' => 20),
                array('apellido_paterno, apellido_materno', 'length', 'max' => 30),
                array('telefono, celular', 'length', 'max' => 10),
                array('email', 'length', 'max' => 255),
                array('carga_familiar', 'numerical'),
                array('tipo', 'length', 'max' => 7),
                array('estado', 'length', 'max' => 8),
                array('descripcion, fecha_actualizacion', 'safe'),
                array('tipo', 'in', 'range' => array('FUNDADOR', 'NUEVO')), // enum,
                array('estado', 'in', 'range' => array('ACTIVO', 'INACTIVO')), // enum,
                array('segundo_nombre, apellido_materno, ruc, telefono, celular, email, descripcion, tipo, estado, fecha_actualizacion, usuario_actualizacion_id, aprobado, direccion_domicilio_id, direccion_negocio_id', 'default', 'setOnEmpty' => true, 'value' => null),
                array('id, primer_nombre, segundo_nombre, apellido_paterno, apellido_materno, cedula, ruc, telefono, celular, email, descripcion, tipo, estado, fecha_creacion, fecha_actualizacion, usuario_creacion_id, usuario_actualizacion_id, aprobado, sucursal_id, persona_etapa_id, direccion_domicilio_id, direccion_negocio_id', 'safe', 'on' => 'search'),
            )
        );
    }

    public function searchParams()
    {
        return array(
            'nombre_formato',
            'cedula',
//            'telefono',
//            'celular',
//            'email',
//            'actividad_economica_id',
//            'sucursal_id',
//            'persona_etapa_id',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->with = array('actividad_economica', 'sucursal', 'personaEtapa');
        $criteria->join = 'LEFT JOIN direccion ON direccion.id = t.direccion_domicilio_id';
        $criteria->join .= ' LEFT JOIN parroquia ON parroquia.id = direccion.parroquia_id';


//        $criteria->compare('t.id', $this->id, true, 'OR');
//        $criteria->compare('primer_nombre', $this->primer_nombre, true,'OR');
//        $criteria->compare('segundo_nombre', $this->segundo_nombre, true,'OR');
//        $criteria->compare('apellido_paterno', $this->apellido_paterno, true,'OR');
//        $criteria->compare('apellido_materno', $this->apellido_materno, true,'OR');
//        $criteria->compare('CONCAT(t.primer_nombre, IFNULL(CONCAT(" ",t.segundo_nombre),""), CONCAT(" ",t.apellido_paterno), IFNULL(CONCAT(" ",t.apellido_materno),""))', $this->nombre_formato, true, 'OR');
        $criteria->compare('t.cedula', $this->cedula, true, 'OR');
//        $criteria->compare('ruc', $this->ruc, true);
        $criteria->compare('t.telefono', $this->telefono, true, 'OR');
        $criteria->compare('t.celular', $this->celular, true, 'OR');
        $criteria->compare('t.email', $this->email, true, 'OR');

        $criteria->compare('sexo', $this->sexo, true);
        $criteria->compare('estado_civil', $this->estado_civil, true);
        $criteria->compare('discapacidad', $this->discapacidad, true);

//        $criteria->compare('parroquia.canton_id', $this->direccion_domicilio_id, true, 'OR');
//        $criteria->compare('descripcion', $this->descripcion, true,'OR');
//        $criteria->compare('tipo', $this->tipo, true,'OR');
//        $criteria->compare('estado', $this->estado, true,'OR');
//        $criteria->compare('fecha_creacion', $this->fecha_creacion, true,'OR');
//        $criteria->compare('fecha_actualizacion', $this->fecha_actualizacion, true,'OR');
//        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
//        $criteria->compare('usuario_actualizacion_id', $this->usuario_actualizacion_id);
//        $criteria->compare('aprobado', $this->aprobado);
        $criteria->compare('actividad_economica.nombre', $this->actividad_economica_id, true, 'OR');
//        $criteria->compare('sucursal.nombre', $this->sucursal_id, true, 'OR');
        $criteria->compare('personaEtapa.nombre', $this->persona_etapa_id, true, 'OR');
//        $criteria->compare('direccion_domicilio_id', $this->direccion_domicilio_id);
//        $criteria->compare('direccion_negocio_id', $this->direccion_negocio_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'CONCAT(CONCAT(" ",t.apellido_paterno), IFNULL(CONCAT(" ",t.apellido_materno),""),t.primer_nombre, IFNULL(CONCAT(" ",t.segundo_nombre),"")) ASC',
            )
        ));
    }

    public function scopes()
    {
        return array(
            'activos' => array(
                'condition' => 't . estado = :estado',
                'params' => array(
                    ':estado' => self::ESTADO_ACTIVO,
                ),
            ),
            'madreSoltera' => array(
                'condition' => 't . sexo = :sexo AND t . carga_familiar > 0 AND t . estado_civil =:estado_civil',
                'params' => array(
                    ':sexo' => 'F',
                    ':estado_civil' => self::ESTADO_CIVIL_SOLTERO,
                ),
            ),
        );
    }

    public function de_canton($cantones)
    {
        if ($cantones) {
            $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => "parroquia.canton_id in({$cantones})",
                )
            );
        }
        return $this;
    }

    public function de_sucursal($sucursal_ids)
    {
        if ($sucursal_ids) {
            $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => "t.sucursal_id in({$sucursal_ids})",
                )
            );
        }
        return $this;
    }

    public function de_ids($ids)
    {
        if ($ids) {
            $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => "t.id in({$ids})",
                )
            );
        }
        return $this;
    }

    public function getGenero()
    {
        if ($this->sexo == 'M') {
            return self::SEXO_MASCULINO;
        } else if ($this->sexo == 'F') {
            return self::SEXO_FEMENINO;
        }
        return null;
    }

    //    public function getTipoIdentificacion() {
    //        if ($this->tipo_identificacion == 'C') {
    //            return self::TIPO_CEDULA;
    //        } else {
    //            return self::TIPO_PASAPORTE;
    //        }
    //        return null;
    //    }

    public function etapa_activos()
    {
        $c_activos = Yii::app()->db->createCommand()
            ->select(' * ')
            ->from('persona p')
            ->join('persona_etapa e', 'p . persona_etapa_id = e . id')
            ->where(array(' and ', 'e . id = 3', 'p . aprobado = 0'))
            ->queryAll();
        //return $c_activos;
        $c_activos_data = new CArrayDataProvider($c_activos, array(
            'keyField' => 'id',
            'pagination' => array('pageSize' => 30,)
        ));
        return $c_activos_data;
    }

    /*
     * devuelve los socios activos que pueden acceder a un crédito (que estén al día en sus pagos)
     */

    public function condicion_socio_credito()
    {
        /* select * from persona pe
          where (id not in (select ah.socio_id from ahorro ah where ah.estado='DEUDA'))
          and (id not in (select cr.socio_id from credito cr where cr.estado='DEUDA')) */
        $garantes = Persona::model()->activos()->findAll(array(
            'condition' => '(t . estado =:estado) and (t . id not in(select ah . socio_id from ahorro ah where ah . estado = "DEUDA"))
          and (t . id not in(select cr . socio_id from credito cr where cr . estado = "DEUDA"))',
            'params' => array(
                ':estado' => self::ESTADO_ACTIVO,
            ),
        ));
        return $garantes;
    }

    /*
     * devuelve los socios activos que pueden ser garantes para dar un crédito (que estén al día en sus pagos)
     */

    public function condicion_garante_credito($socio_id = null)
    {
        /* select * from persona pe
          where (id not in (select ah.socio_id from ahorro ah where ah.estado='DEUDA'))
          and (id not in (select cr.socio_id from credito cr where cr.estado='DEUDA')) */
        $garantes = Persona::model()->activos()->findAll(array(
            'condition' => '(t . estado =:estado) and (t . id not in(select ah . socio_id from ahorro ah where ah . estado = "DEUDA"))
          and (t . id not in(select cr . socio_id from credito cr where cr . estado = "DEUDA")) and (t . id !=:socio_id)',
            'params' => array(
                ':estado' => self::ESTADO_ACTIVO,
                ':socio_id' => $socio_id,
            ),
        ));
        return $garantes;
    }

    public function de_tipo($tipo)
    {
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

    public function de_etapa($etapa_id)
    {
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

    public function getNombre_formato()
    {

        $return = $this->apellido_paterno;
        $return = $return . ($this->apellido_materno ? ' ' . $this->apellido_materno : '');
        $return = $return . ' ' . $this->primer_nombre;
        $return = $return . ($this->segundo_nombre ? ' ' . $this->segundo_nombre : '');
        $this->nombre_formato = $return;
        return $this->nombre_formato;
    }

    public function setNombre_formato($nombre_formato)
    {
        $this->nombre_formato = $nombre_formato;
        return $this->nombre_formato;
    }

    public function getCedula_nombre_formato()
    {

        $return = $this->apellido_paterno;
        $return = $return . ($this->apellido_materno ? ' ' . $this->apellido_materno : '');
        $return = $return . ' ' . $this->primer_nombre;
        $return = $return . ($this->segundo_nombre ? ' ' . $this->segundo_nombre : '');
        $this->cedula_nombre_formato = $return . ' - ' . $this->cedula;
        return $this->cedula_nombre_formato;
    }

    public function setcedula_nombre_formato($cedula_nombre_formato)
    {
        $this->cedula_nombre_formato = $cedula_nombre_formato;
        return $this->cedula_nombre_formato;
    }

    public function getNombre_corto()
    {
        $return = $this->primer_nombre . ' ' . $this->apellido_paterno;
        return $return;
    }

    public function generateExcel($parametros)
    {

        $commad = Yii::app()->db->createCommand()
            ->select(
                'CONCAT(p . primer_nombre, IFNULL(CONCAT(" ", p . segundo_nombre), ""), CONCAT(" ", p . apellido_paterno), IFNULL(CONCAT(" ", p . apellido_materno), "")),
        p . cedula,
        p . ruc,
        ae . nombre,
        p . tipo,
        p . telefono,
        p . celular,
        p . email,
        p . carga_familiar,
        p . discapacidad,
        p . fecha_nacimiento,
        p . fecha_creacion,
        p . estado_civil,
        p . sexo,
        p . descripcion')
            ->from('persona p')
            ->leftJoin('actividad_economica ae', 'ae . id = p . actividad_economica_id')
            ->leftJoin('direccion', 'direccion . id = p . direccion_domicilio_id')
            ->leftJoin('parroquia', 'parroquia . id = direccion . parroquia_id')
            ->where('p . estado =:estado', array(':estado' => self::ESTADO_ACTIVO));
        if ($parametros['id']) {
            $ids = $parametros['id'];
            $commad->andWhere("p.id in($ids)");
        }

//        if ( $parametros['canton_ids']) {
//            $cantones=$parametros['canton_ids'];
//            $commad->andWhere("parroquia.canton_id in($cantones)");
//        }
        if ($parametros['sucursal_id']) {
            $cantones = $parametros['sucursal_id'];
            $commad->andWhere("p.sucursal_id in($cantones)");
        }
        if ($parametros['sexo']) {
            $commad->andWhere('p . sexo =:sexo', array(':sexo' => $parametros['sexo']));
        }
        if ($parametros['estado_civil']) {
            $commad->andWhere('p . estado_civil =:estado_civil', array(':estado_civil' => $parametros['estado_civil']));
        }
        if ($parametros['discapacidad']) {
            $commad->andWhere('p . discapacidad =:discapacidad', array(':discapacidad' => $parametros['discapacidad']));
        }
        if ($parametros['madre_soltera'] == 'true') {
            $commad->andWhere('p . sexo = :sexo AND p . carga_familiar > 0 AND p . estado_civil =:estado_civil', array(
                ':sexo' => 'F',
                ':estado_civil' => self::ESTADO_CIVIL_SOLTERO,
            ));
        }
        return $commad->queryAll();
    }

    public function getListSelect2($search_value = null, $credito_socio = false, $credito_garante_socio_id = null)
    {

        $command = Yii::app()->db->createCommand()
            ->select("p.id as id,
             (CONCAT(p.apellido_paterno, IFNULL(CONCAT(' ', p.apellido_materno), ''), CONCAT(' ', p.primer_nombre), IFNULL(CONCAT(' ', p.segundo_nombre), ''),' - ',p.cedula)) as text")
            ->from('persona p')
            ->where('p . estado = :estado', array(':estado' => self::ESTADO_ACTIVO));
        if ($credito_socio) {
            $command->andWhere('(p . id not in(select ah . socio_id from ahorro ah where ah . estado =:estadoAC))
          and (p . id not in(select cr . socio_id from credito cr where cr . estado =:estadoAC))', array(':estadoAC' => Ahorro::ESTADO_DEUDA));
        }
        if ($credito_garante_socio_id) {
            $command->andWhere('(p . id not in(select ah . socio_id from ahorro ah where ah . estado =:estadoAC))
          and (p . id not in(select cr . socio_id from credito cr where cr . estado =:estadoAC)) and (p . id != :socio_id)', array(':estadoAC' => Ahorro::ESTADO_DEUDA, ':socio_id' => $credito_garante_socio_id));
        }
        if ($search_value) {
            $command->andWhere("p.cedula like '{$search_value}%' OR (CONCAT(p.apellido_paterno, IFNULL(CONCAT(' ', p.apellido_materno), ''), CONCAT(' ', p.primer_nombre), IFNULL(CONCAT(' ', p.segundo_nombre), ''))) like '{$search_value}%'");
        }
        $command->order('text ASC');
        $command->limit(10);
        return $command->queryAll();
    }

}
