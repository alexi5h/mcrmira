<?php

Yii::import('ahorro.models._base.BaseAhorroDeposito');

class AhorroDeposito extends BaseAhorroDeposito {

    public static $datat = array();
    public static $datarep = array();

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

        $criteria->compare('id', $this->id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
//        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
//        $criteria->compare('socio_id', $this->socio_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
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
        $commad->select(array(
            "concat(p.apellido_paterno, ifnull(concat(' ', p.apellido_materno, ' '), ' '), p.primer_nombre, ifnull(concat(' ', p.segundo_nombre), ' ')) AS nombres",
            "p.cedula AS cedula",
            "sum(t.cantidad) AS cantidad",
            "DATE_FORMAT(t.fecha_comprobante_entidad, '%Y-%m')  AS fecha"
        ));
        $commad->from("ahorro_deposito t");
        $commad->join("persona p", "p.id = t.socio_id AND p.estado=:estado", array(':estado' => Persona::ESTADO_ACTIVO));
        if ($anio)
            $commad->andWhere("DATE_FORMAT(t.fecha_comprobante_entidad, '%Y') = :anio", array(':anio' => $anio));
        if ($socio_id)
            $commad->andWhere("t.socio_id = :socio_id", array(":socio_id" => $socio_id));
        if ($sucursal_id)
            $commad->andWhere("p.sucursal_id = :sucursal_id", array(":sucursal" => $sucursal_id));
        $commad->group("t.socio_id, DATE_FORMAT(t.fecha_comprobante_entidad, '%Y-%m')");
        $commad->order("DATE_FORMAT(t.fecha_comprobante_entidad, '%Y-%m') ASC");
        return $commad->queryAll();
    }

    public function generateReporteIncSubmotivoPie($fecha_inicio, $fecha_fin, $incidencia_submotivo_id = null, $incidencia_motivo_id = null, $zona_ids = null, $incidencia_categoria_id = null, $formatGroup = "%Y/%m/%d", $sala_ids = null) {
        $report = array();
        self::$datarep = array();
        $fechaInicio = new DateTime($fecha_inicio);
        $fechaFin = new DateTime($fecha_fin);
        $fechaFin->modify('+1 day');
        $datareportes = $this->dataReporteIncSubmotivo($fechaInicio->format('Y-m-d 00:00:00'), $fechaFin->format('Y-m-d 23:59:59'), $incidencia_submotivo_id, $incidencia_motivo_id, $zona_ids, $incidencia_categoria_id, $formatGroup, false, $sala_ids);
        $data_names = Util::array_column($datareportes, 'name');
        $data_names = array_unique($data_names);
        $dataSumotivo = array();
        $cont = 0;
        foreach ($data_names as $value) {
            array_push($dataSumotivo, array('name' => $value));
            $cont++;
            if ($cont == 10) {
                break;
            }
        }
        self::$datarep = $dataSumotivo;
        foreach (self::$datarep as $key => $value) {
            self::$datarep[$key]["data"] = array();
        }
        foreach (Util::array_column($dataSumotivo, 'name') as $key => $value) {
            self::$datat = array();
            $date = $value;
            $this->recursive_array_search($date, $datareportes);
            $dataEsatdosReporte = Util::array_column(self::$datat, "name");
            $estadosFalta = array_diff(Util::array_column($dataSumotivo, 'name'), $dataEsatdosReporte);
            if ($estadosFalta) {
                foreach ($estadosFalta as $value) {
                    self::$datat[] = array("name" => $value, 'data' => 0);
                }
            }
            foreach (self::$datarep as $key => $value) {
                foreach (self::$datat as $valuet) {
                    if ($value["name"] == $valuet["name"]) {
                        self::$datarep[$key]['data'][] = $valuet["data"];
                        break;
                    }
                }
            }
        }
        $dataserie = array("type" => "pie", "name" => "Incidencia", "data" => array());
        array_walk(self::$datarep, function ($value, $key) {
            self::$datarep[$key]['data'] = array_sum($value['data']);
        });
        foreach (self::$datarep as $rep) {
            $dataserie["data"][] = array($rep['name'], $rep['data']);
        }
        $report['title']['text'] = '';
        $report["chart"]["marginTop"] = "35";
        $report['credits']['enabled'] = false;
        $report['chart']['height'] = '280';
        $report['plotOptions'] = array(
            'pie' => array(
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => array(
                    'enabled' => false,
                    'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'
                ),
                'showInLegend' => true,
                'tooltip' => array(
                    'pointFormat' => 'Porcentaje: <b>{point.percentage:.1f}%</b><br>{series.name}: <b>{point.y}</b>'
                ),
            )
        );
        $report["series"][] = $dataserie;

        $mostrar = false;
        $bandera = 0;
        foreach ($dataserie['data'] as $datas) {

            foreach ($datas as $key) {

                if ($bandera && $key > 0) {
                    $mostrar = true;
                    $bandera = 0;
                }
                $bandera = 1;
            }
        }

        $report["mostrar"] = $mostrar;
        return $report;
    }

    private function recursive_array_search($needle, $haystack) {
        foreach ($haystack as $value) {
            if ($needle === $value OR ( is_array($value) && $this->recursive_array_search($needle, $value))) {
                self::$datat[] = array("name" => $haystack["name"], "data" => (int) $haystack["total"]);
            }
        }
    }

}
