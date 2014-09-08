<?php

Yii::import('credito.models._base.BaseCredito');

class Credito extends BaseCredito {

    //    estado:DEUDA,PAGADO
    const ESTADO_DEUDA = 'DEUDA';
    const ESTADO_PAGADO = 'PAGADO';
    const INTERES = 5;

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

}
