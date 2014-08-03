<?php

Yii::import('pagos.models._base.BasePagoMes');

class PagoMes extends BasePagoMes {

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
        $mes = date("m");
        $mesletras;
        switch ($mes) {
            case "01":
                $mesletras = "Enero";
                break;
            case "02":
                $mesletras = "Febrero";
                break;
            case "03":
                $mesletras = "Marzo";
                break;
            case "04":
                $mesletras = "Abril";
                break;
            case "05":
                $mesletras = "Mayo";
                break;
            case "06":
                $mesletras = "Junio";
                break;
            case "07":
                $mesletras = "Julio";
                break;
            case "08":
                $mesletras = "Agosto";
                break;
            case "09":
                $mesletras = "Septiembre";
                break;
            case "10":
                $mesletras = "Octubre";
                break;
            case "11":
                $mesletras = "Noviembre";
                break;
            case "12":
                $mesletras = "Diciembre";
                break;
            default:
                $mesletras="--";
        }
        $año = date("Y");
        return "C_" . $id_cliente . "_" . $mesletras . "_" . $año;
    }
}
