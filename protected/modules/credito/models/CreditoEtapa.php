<?php

Yii::import('credito.models._base.BaseCreditoEtapa');

class CreditoEtapa extends BaseCreditoEtapa
{
    /**
     * @return CreditoEtapa
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Etapa de Crédito|Etapas de Crédito', $n);
    }

}