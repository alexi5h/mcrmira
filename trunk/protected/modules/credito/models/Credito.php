<?php

Yii::import('credito.models._base.BaseCredito');

class Credito extends BaseCredito {

    //    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';
    //Porcentaje del interes
    const INTERES = 5;
    //anulado: SI,NO
    const NO_ANULADO = 'NO';
    const ANULADO = 'SI';

    //Filtros de búsqueda
    public $ano_creacion;
    public $mes_creacion;

    /**
     * @return Credito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Crédito|Créditos', $n);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'socio' => array(self::BELONGS_TO, 'Persona', 'socio_id'),
            'garante' => array(self::BELONGS_TO, 'Persona', 'garante_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_id'),
                )
        );
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'periodos' => Yii::t('app', 'Plazo (meses)'),
            'numero_cheque' => Yii::t('app', 'Número Cheque'),
            'fecha_credito' => Yii::t('app', 'Fecha Crédito'),
            'fecha_limite' => Yii::t('app', 'Fecha Límite'),
            'total_interes' => Yii::t('app', 'Total Intereses'),
                )
        );
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('socio_id, garante_id, sucursal_id, fecha_limite, cantidad_total, periodos', 'required'),
            array('periodos, cantidad_total, numero_cheque', 'numerical'),
            array('numero_cheque', 'unique', 'message' => 'Ya existe un crédito con este número de cheque!'),
        ));
    }

    public function scopes() {
        return array(
            'en_deuda' => array(
                'condition' => 't.estado = :estado',
                'params' => array(
                    ':estado' => self::ESTADO_DEUDA,
                ),
            ),
        );
    }

    public function de_numeros_cheque($num_cheques) {
        if ($num_cheques) {
            $this->getDbCriteria()->mergeWith(
                    array(
                        'condition' => "t.numero_cheque in({$num_cheques})",
                    )
            );
        }
        return $this;
    }

    public function de_socio($socio_id) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 't.socio_id = :socio_id',
                    'params' => array(
                        ':socio_id' => $socio_id
                    ),
                )
        );
        return $this;
    }

    public function de_socios($socio_ids) {
        if ($socio_ids) {
            $this->getDbCriteria()->mergeWith(
                    array(
                        'condition' => "t.socio_id in({$socio_ids})",
                    )
            );
        }
        return $this;
    }

    public function de_sucursales($sucursal_ids) {
        if ($sucursal_ids) {
            $this->getDbCriteria()->mergeWith(
                    array(
                        'condition' => "t.sucursal_id in({$sucursal_ids})",
                    )
            );
        }
        return $this;
    }

    public function de_fechas($año = null, $mes = null, $fechas = null) {
        if ($año) {
            if ($mes) {
                $this->getDbCriteria()->mergeWith(
                        array(
                            'condition' => "DATE_FORMAT(t.fecha_credito,'%Y/%m') in ({$fechas})",
                        )
                );
            } else {
                $this->getDbCriteria()->mergeWith(
                        array(
                            'condition' => "DATE_FORMAT(t.fecha_credito,'%Y') in ({$año})",
                        )
                );
            }
        } elseif ($mes) {
            $this->getDbCriteria()->mergeWith(
                    array(
                        'condition' => "DATE_FORMAT(t.fecha_credito,'%m') in ({$mes})",
                    )
            );
        }
        return $this;
    }

    /*     * total tes dashboard* */

    public function getTotalCreditos() {
//select  sum(total_pagar) from  credito where anulado='NO' and estado='PAGADO'


        $command = Yii::app()->db->createCommand()
                ->select('sum(total_pagar) as total')
                ->from('credito')
                ->where('anulado=:anulado_no and estado=:estado_pagado'
                , array(':anulado_no' => self::NO_ANULADO, ':estado_pagado' => self::ESTADO_PAGADO));
        $result = $command->queryAll();
        return $result[0]['total'] ? $result[0]['total'] : 0;
    }

    public function getTotalCreditosDeuda() {
//select  sum(saldo_contra) from  credito where anulado='NO' and estado='DEUDA'


        $command = Yii::app()->db->createCommand()
                ->select('sum(saldo_contra) as total')
                ->from('credito')
                ->where('anulado=:anulado_no and estado=:estado_pagado'
                , array(':anulado_no' => self::NO_ANULADO, ':estado_pagado' => self::ESTADO_DEUDA));
        $result = $command->queryAll();
        return $result[0]['total'] ? $result[0]['total'] : 0;
    }

    public function beforeSave() {
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_id = Util::getSucursal();
        return parent::beforeValidate();
    }

//    public function search() {
//        $criteria = new CDbCriteria;
//
//        $criteria->compare('id', $this->id);
//        $criteria->compare('socio_id', $this->socio_id);
//        $criteria->compare('garante_id', $this->garante_id);
//        $criteria->compare('sucursal_id', $this->sucursal_id);
//        $criteria->compare('fecha_credito', $this->fecha_credito, true);
//        $criteria->compare('fecha_limite', $this->fecha_limite, true);
//        $criteria->compare('cantidad_total', $this->cantidad_total, true);
//        $criteria->compare('total_pagar', $this->total_pagar, true);
//        $criteria->compare('interes', $this->interes, true);
//        $criteria->compare('total_interes', $this->total_interes, true);
//        $criteria->compare('estado', $this->estado, true);
//        $criteria->compare('periodos', $this->periodos);
//        $criteria->compare('saldo_contra', $this->saldo_contra, true);
//        $criteria->compare('saldo_favor', $this->saldo_favor, true);
//        $criteria->compare('anulado', $this->anulado, true);
//        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
//        $criteria->compare('numero_cheque', $this->numero_cheque, true,'OR');
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
//    }

    public function getListSelect2($socio_ids = null, $search_value = null) {
        $command = Yii::app()->db->createCommand()
                ->select("cr.numero_cheque as id, cr.numero_cheque as text")
                ->from('credito cr');
        if ($socio_ids) {
            $command->andWhere('cr.socio_id in (' . $socio_ids . ')');
        }
        if ($search_value) {
            $command->andWhere("cr.numero_cheque like '$search_value%'");
        }
        $command->limit(10);
        return $command->queryAll();
    }

}
