<?php

Yii::import('ahorro.models._base.BaseAhorro');
Yii::import('crm.models.Persona');

class Ahorro extends BaseAhorro {

    //    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';
//    tipo:AHORRO,PRIMER_PAGO
    const TIPO_AHORRO = 'AHORRO';
    const TIPO_PRIMIER_PAGO = 'PRIMER_PAGO';
    //Valor a pagar por registro en la mancomunidad
    const VALOR_REGISTRO = 70;

    /**
     * @return Ahorro
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Ahorro|Ahorros', $n);
    }

    public function relations() {
        return array(
            'ahorroDepositos' => array(self::HAS_MANY, 'AhorroDeposito', 'pago_id'),
            'socio' => array(self::BELONGS_TO, 'Persona', 'socio_id'),
        );
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('cantidad', 'numerical', 'min' => 1, 'tooSmall' => 'La cantidad debe ser mayor a 0'),
            array('tipo', 'unique', 'criteria' => array(
                    'condition' => 'socio_id=:socio_id',
                    'params' => array(
                        ':socio_id' => $this->socio_id
                    )
                ), 'on' => 'insert'),
                )
        );
    }

    public function de_cliente($id_socio) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'socio_id = :socio_id',
                    'params' => array(
                        ':socio_id' => $id_socio
                    ),
                )
        );
        return $this;
    }

    public static function fechaMes($id_cliente) {
        $mes = date("m") + 0;
        $meses = Util::obtenerMeses();
        $año = date("Y");
        return "C_" . $id_cliente . "_" . $meses[$mes - 1] . "_" . $año;
    }

}
