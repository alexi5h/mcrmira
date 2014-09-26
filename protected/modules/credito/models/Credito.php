<?php

Yii::import('credito.models._base.BaseCredito');

class Credito extends BaseCredito {

    //    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';
    //Porcentaje del interes
    const INTERES = 5;
    //anulado: SI,NO
    const NO_ANULADO='NO';
    const ANULADO='SI';

    /**
     * @return Credito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Credito|Creditos', $n);
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
                )
        );
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('socio_id, garante_id, sucursal_id, fecha_limite, cantidad_total, periodos', 'required'),
            array('periodos, cantidad_total', 'numerical'),
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

}
