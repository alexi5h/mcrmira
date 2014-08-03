<?php

Yii::import('pagos.models._base.BasePagoMes');

class PagoMes extends BasePagoMes {

    const ESTADO_DEUDA= 'DEUDA';
    const ESTADO_PAGADO= 'PAGADO';
    /**
     * @return PagoMes
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'PagoMes|PagoMes', $n);
    }

    public static function fechaMes($id_cliente) {
        $mes = date("m")+0;
        $meses=Util::obtenerMeses();
        $año = date("Y");
        return "C_" . $id_cliente . "_" . $meses[$mes-1] . "_" . $año;
    }
}
