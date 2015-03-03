<?php

Yii::import('ahorro.models._base.BaseAhorroDetalle');

class AhorroDetalle extends BaseAhorroDetalle
{
    /**
     * @return AhorroDetalle
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AhorroDetalle|AhorroDetalles', $n);
    }

}