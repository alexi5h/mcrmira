<?php

Yii::import('pagos.models._base.BasePago');

class Pago extends BasePago {
//    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';
//    tipo:AHORRO,PRIMER_PAGO
    const TIPO_AHORRO='AHORRO';
    const TIPO_PRIMIER_PAGO='PRIMER_PAGO';
    //Valor a pagar por registro en la mancomunidad
    const VALOR_REGISTRO = 70;

    /**
     * @return PagoMes
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Pago|Pago', $n);
    }

    public function de_cliente($id_cliente) {
        $this->getDbCriteria()->mergeWith(
                array(
                    'condition' => 'cliente_id = :cliente_id',
                    'params' => array(
                        ':cliente_id' => $id_cliente
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
