<?php

Yii::import('ahorro.models._base.BaseAhorroExtra');

class AhorroExtra extends BaseAhorroExtra
{
    const ANULADO = 'SI';
    const NO_ANULADO = 'NO';


    /**
     * @return AhorroExtra
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AhorroExtra|AhorroExtras', $n);
    }

    public function beforeSave()
    {
        $this->fecha_creacion = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        $this->fecha_creacion = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        return parent::beforeValidate();
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