<?php

Yii::import('ahorro.models._base.BaseAhorroDeposito');

class AhorroDeposito extends BaseAhorroDeposito {

    public static $datat = array();
    public static $datarep = array();
    public $fechaMes = array();

    /**
     * @return AhorroDeposito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array_merge(parent::rules(), array(
//            array('cantidad', 'numerical', 'integerOnly' => false, 'max' => $this->ahorro->saldo_contra),
            array('socio_id', 'required'),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'entidadBancaria' => array(self::BELONGS_TO, 'EntidadBancaria', 'entidad_bancaria_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_comprobante_id'),
            'socio' => array(self::BELONGS_TO, 'Persona', 'socio_id'),
        ));
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Deposito|Depositos', $n);
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'entidad_bancaria_id' => Yii::t('app', 'Entidad Bancaria'),
            'cod_comprobante_entidad' => Yii::t('app', 'Comprobante'),
            'fecha_comprobante_entidad' => Yii::t('app', 'Fecha'),
            'sucursal_comprobante_id' => Yii::t('app', 'Cantón'),
            'cod_comprobante_su' => Yii::t('app', 'Cod Comprobante Su'),
            'fecha_comprobante_su' => Yii::t('app', 'Fecha Comprobante Su'),
            'usuario_creacion_id' => Yii::t('app', 'Usuario Creacion'),
            'socio_id' => Yii::t('app', 'Socio'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('socio');

//        $criteria->compare('id', $this->id);
//        $criteria->compare('cantidad', $this->cantidad, true);
//        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
//        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
//        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
////        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
//        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
//        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
//        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
        $criteria->compare('socio.estado', Persona::ESTADO_ACTIVO);
//        $criteria->compare('socio_id', $this->socio_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function scopes() {

        return array(
            'deMes' => array(
                'condition' => 'MONTH(t.fecha_comprobante_entidad) = :mes AND YEAR(t.fecha_comprobante_entidad)=:anio',
                'params' => array(
                    ':mes' => $this->fechaMes[0],
                    ':anio' => $this->fechaMes[1],
                ),
            ),
        );
    }

    public function de_socio($ids) {

        if ($ids) {
            $this->getDbCriteria()->mergeWith(
                    array(
                        'condition' => "t.socio_id in({$ids})",
                    )
            );
        }
        return $this;
    }

    public function de_sucursal($sucursal_ids) {
        if ($sucursal_ids) {
            $this->getDbCriteria()->mergeWith(
                    array(
                        'condition' => "t.sucursal_comprobante_id in({$sucursal_ids})",
                    )
            );
        }
        return $this;
    }

    public function beforeSave() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
//        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
//        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeValidate();
    }

    public function searchByAhorro($id_ahorro) {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
//        $criteria->compare('ahorro_id', $id_ahorro);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }

    public function totalDepositosByPago($id_ahorro) {
//        select sum(t.cantidad) from deposito t where t.pago_id=1;
        $consulata = Yii::app()->db->createCommand()->
                select('sum(t.cantidad) as total_depositos_pago')->
                from('ahorro_deposito t')->
                where('t.pago_id=:pago_id');
        $consulata->params = array(':pago_id' => $id_ahorro);

        return $consulata->queryAll();
    }

    /**
     * Obtiene la suma de todo, los depositos realizados un socio
     */
    public function sumTotaldeposito($socio_id = null) {
        $command = new CDbCommand(Yii::app()->db);
        $command->select('ifnull(sum(t.cantidad),0)');
        $command->from('ahorro_deposito t');
        if ($socio_id)
            $command->andWhere('t.socio_id=:socio_id', array(':socio_id' => $socio_id));
        return $command->queryScalar();
    }

    public function searchDepositosSocio($socio_id = null) {
        $criteria = new CDbCriteria;
        $sort = new CSort;
//        $criteria->with = array('ahorro');
        $criteria->addCondition('t.socio_id=:socio_id', 'AND');
//        $criteria->mergeWith(CreditoDeposito::model()->searchDepositosSocio($socio_id));
//        $criteria->addCondition('t.id not in (select ev.cuenta_id from evento_visita ev where ev.estado=:ev_estado)', 'AND');
//        $criteria->addCondition('(t.frecuencia is not null OR t.frecuencia>0)', 'AND');

        $params = array(
            ':socio_id' => $socio_id,
        );
        $criteria->params = array_merge($criteria->params, $params);
        /* Sort criteria */

        $sort->attributes = array(
            'fecha_comprobante_su' => array(
                'asc' => 't.fecha_comprobante_su asc',
                'desc' => 't.fecha_comprobante_su desc',
            ),
            '*',
        );
        $sort->defaultOrder = 't.fecha_comprobante_su asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, 'sort' => $sort,
            'pagination' => false
        ));
    }

    public function generarCodigoComprobante($socio_id = '') {
        $result = date('y') . date('m') . date('d') . date('H') . date('i') . date('s') . $socio_id;
        return $result;
    }

    public function dataConsolidato($anio = null, $socio_id = null, $sucursal_id = null) {
        $commad = new CDbCommand(Yii::app()->db);

        $socio_condicion = $socio_id ? "AND p.id  in({$socio_id})" : "";
        $sucursal_condicio = $sucursal_id ? "AND p.sucursal_id in ({$sucursal_id})" : "";
        $e = Persona::ESTADO_ACTIVO;
        $anio_condicion=Util::AnioActual()==$anio ?"":" AND DATE_FORMAT(ahs.fecha_comprobante_entidad, '%Y') <= '{$anio}'";

        $estado = "AND p.estado='{$e}' ";

        $commad->setText("
        (SELECT
           p.id,
           s.nombre as sucursal,
           ifnull((SELECT sum(ahs.cantidad)
                   FROM ahorro_deposito ahs
                   WHERE ahs.socio_id = p.id AND DATE_FORMAT(ahs.fecha_comprobante_entidad, '%Y') < '{$anio}'), 0) AS saldo,
           concat(p.apellido_paterno, ifnull(concat(' ', p.apellido_materno, ' '), ' '), p.primer_nombre,
                  ifnull(concat(' ', p.segundo_nombre), ' '))                                                   AS nombres,
           p.cedula                                                                                             AS cedula,
           sum(t.cantidad)                                                                                      AS cantidad,
           DATE_FORMAT(t.fecha_comprobante_entidad, '%Y-%m')                                                    AS fecha,
           ifnull((SELECT sum(ahs.cantidad)
                   FROM ahorro_deposito ahs
                   WHERE ahs.socio_id = p.id {$anio_condicion}), 0)                                                               AS total
         FROM ahorro_deposito t
           INNER JOIN persona p ON p.id = t.socio_id
           INNER JOIN sucursal s on s.id=p.sucursal_id
         WHERE DATE_FORMAT(t.fecha_comprobante_entidad, '%Y') = '{$anio}' {$socio_condicion} {$sucursal_condicio} {$estado}
         GROUP BY t.socio_id, DATE_FORMAT(t.fecha_comprobante_entidad, '%Y-%m')
        )
        UNION
        (SELECT
           p.id,
           s.nombre as sucursal,
           0                                                  AS saldo,
           concat(p.apellido_paterno, ifnull(concat(' ', p.apellido_materno, ' '), ' '), p.primer_nombre,
                  ifnull(concat(' ', p.segundo_nombre), ' ')) AS nombres,
           p.cedula                                           AS cedula,
           0                                                  AS cantidad,
           NULL                                               AS fecha,
           0                                                  AS total
         FROM persona p
         INNER JOIN sucursal s on s.id=p.sucursal_id
         WHERE p.id NOT IN (SELECT ad.socio_id
                            FROM ahorro_deposito ad)
                            {$socio_condicion} {$sucursal_condicio} {$estado}
        )

        ORDER BY nombres ASC
        ");
        return $commad->queryAll();
    }

    public function generateDataGridDepositos($parametros) {
//select 
//CONCAT(p.primer_nombre, IFNULL(CONCAT(" ",p.segundo_nombre),""), CONCAT(" ",p.apellido_paterno), IFNULL(CONCAT(" ",p.apellido_materno),"")),
//p.cedula,
//ad.cantidad,
//ad.fecha_comprobante_entidad,
//ad.cod_comprobante_entidad,
//s.nombre
// from persona p
//inner join ahorro_deposito ad on ad.socio_id=p.id
//inner join sucursal s on s.id=ad.sucursal_comprobante_id
//where p.estado='ACTIVO'
// and p.id in(1,2,3)
//and ad.sucursal_comprobante_id in(1,2,3)
//and MONTH(ad.fecha_comprobante_entidad) = '3' AND YEAR(ad.fecha_comprobante_entidad)='2015'

        $commad = Yii::app()->db->createCommand()
                ->select(
                        'CONCAT(p.primer_nombre, IFNULL(CONCAT(" ",p.segundo_nombre),""), CONCAT(" ",p.apellido_paterno), IFNULL(CONCAT(" ",p.apellido_materno),"")),
     p.cedula,
ad.cantidad,
ad.fecha_comprobante_entidad,
ad.cod_comprobante_entidad,
s.nombre')
                ->from('persona p')
                ->join('ahorro_deposito ad', 'ad.socio_id=p.id')
                ->join('sucursal s', 's.id=ad.sucursal_comprobante_id')
                ->where('p.estado=:estado', array(':estado' => Persona::ESTADO_ACTIVO));


        if ($parametros['socio_id']) {
            $ids = $parametros['socio_id'];
            $commad->andWhere("p.id in($ids)");
        }
        if ($parametros['sucursal_comprobante_id']) {
            $ids = $parametros['sucursal_comprobante_id'];
            $commad->andWhere("ad.sucursal_comprobante_id in($ids)");
        }

        if ($parametros['fecha_comprobante_entidad']) {
            $arrayFecha = explode('/', $parametros['fecha_comprobante_entidad']);
            if (count($arrayFecha) > 1) {
                $commad->andWhere("MONTH(ad.fecha_comprobante_entidad) =:mes AND YEAR(ad.fecha_comprobante_entidad)=:anio", array(':mes' => array_search($arrayFecha[0], Util::obtenerMeses()) + 1, ':anio' => $arrayFecha[1]));
            }
        }


        return $commad->queryAll();
    }

    public function generateDataGridConsolidado($anio, $socio_id = null, $sucursal_id = null) {
        $data = $this->dataConsolidato($anio, $socio_id, $sucursal_id);
        $cedulas = array_unique(Util::array_column($data, 'cedula')); // Recojo todos las cedulas
        $meses = array(
            "{$anio}-01",
            "{$anio}-02",
            "{$anio}-03",
            "{$anio}-04",
            "{$anio}-05",
            "{$anio}-06",
            "{$anio}-07",
            "{$anio}-08",
            "{$anio}-09",
            "{$anio}-10",
            "{$anio}-11",
            "{$anio}-12"
        );
        self::$datarep = array();
        $id = 1;
        foreach ($cedulas as $cedula) {
            self::$datat = array();
            $this->recursive_array_search($cedula, $data);
            self::$datat; // en esta variable se guarda todos los depositos que realizo el socio
            $mesesFalta = array_diff($meses, Util::array_column(self::$datat, 'fecha')); // averiguo que meses no estan pagados para ponerlos en cero cada mes
            $registro = end(self::$datat); // se lo usa como refencia para saber el formoato del registro a aumentarse
            if ($mesesFalta) {
                foreach ($mesesFalta as $mesFalta) {
                    self::$datat[] = array(
                        'id' => $registro['id'], 'saldo' => $registro['saldo'], 'nombres' => $registro['nombres'],
                        'cedula' => $registro['cedula'], 'cantidad' => (float) 0,
                        'fecha' => $mesFalta,
                        'total' => $registro['total']
                    );
                }
                $dta = self::$datat;
                self::$datat = array();
                //quito los gegistros que tiene fehca null
                array_walk($dta, function ($value, $key) {
                    if ($value['fecha'])//si el valor de la fecha es no es null agrege
                        self::$datat[] = $value;
                });
            }
            // Ordeno los registros por fecha de menor a mayor: ene,feb,mar,abr,mar,may,jun...
            usort(self::$datat, function ($a, $b) {
                return ($a['fecha'] < $b['fecha']) ? -1 : 1;
            });
            $r = array_combine(Util::obtenerMeses(), Util::array_column(self::$datat, 'cantidad')); // Construyo el registro de depositos por meses
            $r['Nombres'] = $registro['nombres'];
            $r['Cedula'] = $registro['cedula'];
            $r['Saldo'] = $registro['saldo'];
            $r['Total'] = $registro['total'];
            $r['Sucursal'] = $registro['sucursal'];
            $r['id'] = $id++;
            self::$datarep[] = $r;
        }
        return self::$datarep;
    }

    private function recursive_array_search($needle, $haystack) {
        foreach ($haystack as $value) {
            if ($needle === $value OR ( is_array($value) && $this->recursive_array_search($needle, $value))) {
                self::$datat[] = array(
                    'id' => $haystack['id'], 'sucursal' => $haystack['sucursal'], 'saldo' => (float) $haystack['saldo'], 'nombres' => $haystack['nombres'],
                    'cedula' => $haystack['cedula'], 'cantidad' => (float) $haystack['cantidad'],
                    'fecha' => $haystack['fecha'],
                    'total' => (float) $haystack['total']
                );
            }
        }
    }

}
