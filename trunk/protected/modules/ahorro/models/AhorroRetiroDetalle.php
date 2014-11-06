<?php

Yii::import('ahorro.models._base.BaseAhorroRetiroDetalle');

class AhorroRetiroDetalle extends BaseAhorroRetiroDetalle
{
    /**
     * @return AhorroRetiroDetalle
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'AhorroRetiroDetalle|AhorroRetiroDetalles', $n);
    }

    public function beforeSave()
    {
        $this->usuario_creacion_id = Yii::app()->user->id;
        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        $this->usuario_creacion_id = Yii::app()->user->id;
        return parent::beforeValidate();
    }

}