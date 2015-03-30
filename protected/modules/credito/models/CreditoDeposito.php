<?php

Yii::import('credito.models._base.BaseCreditoDeposito');

class CreditoDeposito extends BaseCreditoDeposito {

    public $socio_id;
    public static $datat = array();
    public static $datarep = array();

    /**
     * @return CreditoDeposito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Depósito de Crédito|Depósitos de Crédito', $n);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'entidadBancaria' => array(self::BELONGS_TO, 'EntidadBancaria', 'entidad_bancaria_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_comprobante_id'),
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'cantidad' => Yii::t('app', 'Capital'),
            'interes' => Yii::t('app', 'Interés'),
        ));
    }

    public function de_credito($credito_id) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 't.credito_id = :credito_id',
                    'order' => 't.fecha_comprobante_su DESC',
                    'params' => array(
                        ':credito_id' => $credito_id
                    ),
                )
        );
        return $this;
    }

    public function searchByCredito($credito_id) {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
        $criteria->compare('credito_id', $credito_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }

    public function beforeSave() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeValidate();
    }

    public function searchDepositosSocio($socio_id = null) {
        $criteria = new CDbCriteria;
        $sort = new CSort;
        $criteria->with = array('credito');
        $criteria->addCondition('credito.socio_id=:socio_id', 'AND');
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
        ));
    }

    public function generarCodigoComprobante($socio_id = '') {
        $result = date('y') . date('m') . date('d') . date('H') . date('i') . date('s') . $socio_id;
        return $result;
    }

    public function generarDataCreditoDepositos($socio_id = null, $sucursal_id = null, $anio = null) {
//select cr.numero_cheque,
//       s.nombre as sucursal,
//       concat(p.apellido_paterno, ifnull(concat(' ', p.apellido_materno, ' '), ' '), p.primer_nombre, ifnull(concat(' ', p.segundo_nombre), ' ')) AS nombres,
//       date_format(cr.fecha_credito, "%d/%m/%Y") as fecha_credito,
//       ifnull(
//              (SELECT sum(cds.cantidad)
//              FROM credito_deposito cds
//              WHERE cds.credito_id = cr.id AND date_format(cds.fecha_comprobante_su, '%Y') < 2016), 0) AS pagos_ant,
//       ifnull(
//              (SELECT sum(cdsi.interes)
//              FROM credito_deposito cdsi
//              WHERE cdsi.credito_id = cr.id AND date_format(cdsi.fecha_comprobante_su, '%Y') < 2016), 0) AS interes_ant,
//       sum(cd.cantidad) as capital,
//       sum(cd.interes) as interes,
//       sum(cd.multa) as multa,
//       date_format(cd.fecha_comprobante_su, "%Y-%m") as mes
//from credito_deposito cd
//inner join credito cr on cr.id=cd.credito_id
//inner join sucursal s on s.id=cr.sucursal_id
//inner join persona p on p.id=cr.socio_id
//group by cr.numero_cheque, date_format(cd.fecha_comprobante_su, "%Y/%m");
        $command = Yii::app()->db->createCommand()
                ->select('cr.numero_cheque,
        s.nombre as sucursal,
        concat(p.apellido_paterno, ifnull(concat(" ", p.apellido_materno, " "), " "), p.primer_nombre, ifnull(concat(" ", p.segundo_nombre), " ")) AS nombres,
        date_format(cr.fecha_credito, "%d/%m/%Y") as fecha_credito,
        ifnull(
              (SELECT sum(cds.cantidad)
              FROM credito_deposito cds
              WHERE cds.credito_id = cr.id AND date_format(cds.fecha_comprobante_su, "%Y") < ' . $anio . '), 0) AS pagos_ant,
        ifnull(
              (SELECT sum(cdsi.interes)
              FROM credito_deposito cdsi
              WHERE cdsi.credito_id = cr.id AND date_format(cdsi.fecha_comprobante_su, "%Y") < ' . $anio . '), 0) AS interes_ant,
        sum(cd.cantidad) as capital,
        sum(cd.interes) as interes,
        sum(cd.multa) as multa,
        date_format(cd.fecha_comprobante_su, "%Y-%m") as mes')
                ->from('credito_deposito cd')
                ->join('credito cr', 'cr.id=cd.credito_id')
                ->join('sucursal s', 's.id=cr.sucursal_id')
                ->join('persona p', 'p.id=cr.socio_id');
        if ($socio_id) {
            $command->andWhere('p.id in (' . $socio_id . ')');
        }
        if ($sucursal_id) {
            $command->andWhere('cr.sucursal_id in (' . $sucursal_id . ')');
        }
        if ($anio) {
            $command->andWhere('date_format(cr.fecha_credito,"%Y") between (:anio-1) and :anio', array(':anio' => $anio));
        }
        $command->group('cr.numero_cheque, date_format(cd.fecha_comprobante_su, "%Y/%m")');
        return $command->queryAll();
    }

    public function generarGridCreditoDepositos($socio_id, $sucursal_id, $anio) {
        $data = $this->generarDataCreditoDepositos($socio_id, $sucursal_id, $anio);
        $numeros_cheque = array_unique(Util::array_column($data, 'numero_cheque')); // Recojo todos las cedulas
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

        foreach ($numeros_cheque as $numero_cheque) {
            self::$datat = array();
            $this->recursive_array_search($numero_cheque, $data);
            self::$datat; // en esta variable se guarda todos los depositos que realizo el socio
            $mesesFalta = array_diff($meses, Util::array_column(self::$datat, 'mes')); // averiguo que meses no estan pagados para ponerlos en cero cada mes
//            var_dump(self::$datat);
//            die();
            $registro = end(self::$datat); // se lo usa como refencia para saber el formoato del registro a aumentarse
            if ($mesesFalta) {
                foreach ($mesesFalta as $mesFalta) {
                    self::$datat[] = array(
                        'numero_cheque' => $registro['numero_cheque'],
                        'sucursal' => $registro['sucursal'],
                        'fecha_credito' => $registro['fecha_credito'],
                        'pagos_ant' => (float) $registro['pagos_ant'],
                        'interes_ant' => (float) $registro['interes_ant'],
                        'nombres' => $registro['nombres'],
                        'capital' => 0,
                        'interes' => 0,
                        'multa' => 0,
                        'mes' => $mesFalta,
                    );
                }
                $dta = self::$datat;
                self::$datat = array();
                //quito los gegistros que tiene fehca null
                array_walk($dta, function ($value, $key) {
                    if ($value['mes'])//si el valor de la fecha es no es null agrege
                        self::$datat[] = $value;
                });
            }
            // Ordeno los registros por fecha de menor a mayor: ene,feb,mar,abr,mar,may,jun...
            usort(self::$datat, function ($a, $b) {
                return ($a['mes'] < $b['mes']) ? -1 : 1;
            });
            $r = array_combine(Util::obtenerMeses(), Util::array_column(self::$datat, 'capital')); // Construyo el registro de depositos por meses
            $r_interes = array_combine(Util::obtenerMeses(), Util::array_column(self::$datat, 'interes')); // Construyo el registro de depositos por meses
            array_push($r, $r_interes);
            $r_multa = array_combine(Util::obtenerMeses(), Util::array_column(self::$datat, 'multa')); // Construyo el registro de depositos por meses
            array_push($r, $r_multa);
            $r['Nombres'] = $registro['nombres'];
            $r['pagos_ant'] = $registro['pagos_ant'];
            $r['interes_ant'] = $registro['interes_ant'];
            $r['Sucursal'] = $registro['sucursal'];
            $r['numero_cheque'] = $registro['numero_cheque'];
            $r['fecha_credito'] = $registro['fecha_credito'];
            $r['id'] = $id++;
            self::$datarep[] = $r;
        }
        return self::$datarep;
    }

    private function recursive_array_search($needle, $haystack) {
        foreach ($haystack as $value) {
            if ($needle === $value OR ( is_array($value) && $this->recursive_array_search($needle, $value))) {
                self::$datat[] = array(
                    'numero_cheque' => $haystack['numero_cheque'],
                    'sucursal' => $haystack['sucursal'],
                    'fecha_credito' => $haystack['fecha_credito'],
                    'pagos_ant' => (float) $haystack['pagos_ant'],
                    'interes_ant' => (float) $haystack['interes_ant'],
                    'nombres' => $haystack['nombres'],
                    'capital' => (float) $haystack['capital'],
                    'interes' => (float) $haystack['interes'],
                    'multa' => (float) $haystack['multa'],
                    'mes' => $haystack['mes'],
                );
            }
        }
    }

}
