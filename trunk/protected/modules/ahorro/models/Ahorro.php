<?php

Yii::import('ahorro.models._base.BaseAhorro');

class Ahorro extends BaseAhorro {

    //    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';
//    tipo:OBLIGATORIO, VOLUNTARIO, PRIMER_PAGO
    const TIPO_OBLIGATORIO = 'OBLIGATORIO';
    const TIPO_VOLUNTARIO = 'VOLUNTARIO';
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

    public function de_cliente_obligatorio($id_socio) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'socio_id = :socio_id AND tipo=:tipo',
                    'params' => array(
                        ':socio_id' => $id_socio,
                        ':tipo' => self::TIPO_OBLIGATORIO
                    ),
                )
        );
        return $this;
    }

    public function de_cliente_voluntario($id_socio) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'socio_id = :socio_id AND tipo=:tipo',
                    'params' => array(
                        ':socio_id' => $id_socio,
                        ':tipo' => self::TIPO_VOLUNTARIO
                    ),
                )
        );
        return $this;
    }

    public function socioAhorroVoluntarioTotal($id_socio) {
//        select sum(saldo_favor) from ahorro where socio_id=2 and tipo='VOLUNTARIO' and anulado=0
        $command = Yii::app()->db->createCommand()
                ->select('sum(saldo_favor)as total')
                ->from('ahorro ')
                ->where(array('and', 'socio_id=:id_socio', 'tipo=:tipo', 'anulado=0'));
        $command->params = array('id_socio' => $id_socio, 'tipo' => self::TIPO_VOLUNTARIO);

        $return = $command->queryAll();

        return $return[0]['total'];
    }

    /*
     * devuelve los ahorros voluntarios con su respectovo saldo a favor de un cleinte 
     */

    public function socioAhorrosVoluntarios($id_socio) {
//        select id,saldo_favor from ahorro where socio_id=2 and tipo='VOLUNTARIO' and anulado=0 
        $command = Yii::app()->db->createCommand()
                ->select('id,saldo_favor')
                ->from('ahorro ')
                ->where(array('and', 'socio_id=:id_socio', 'tipo=:tipo', 'anulado=0'));
        $command->params = array('id_socio' => $id_socio, 'tipo' => self::TIPO_VOLUNTARIO);

        $return = $command->queryAll();

        return $return;
    }

    public function setAnulado($id, $cantidad = NULL) {
        $toUpdate = array();
        if ($cantidad) {
            $toUpdate = array('cantidad' => $cantidad, 'saldo_favor' => $cantidad);
        } else {
            $toUpdate = array('anulado' => 1);
        }
        $command = Yii::app()->db->createCommand()
                ->update('ahorro', $toUpdate, "id=:id", array(':id' => $id));
    }

    public static function fechaMes($id_cliente) {
        $mes = date("m") + 0;
        $meses = Util::obtenerMeses();
        $año = date("Y");
        return "C_" . $id_cliente . "_" . $meses[$mes - 1] . "_" . $año;
    }

}
