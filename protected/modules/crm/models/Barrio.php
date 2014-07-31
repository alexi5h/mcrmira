<?php

Yii::import('crm.models._base.BaseBarrio');

class Barrio extends BaseBarrio {

    public $provincia_id;
    public $canton_id;

    /**
     * @return Barrio
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Barrio|Barrios', $n);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'parroquia' => array(self::BELONGS_TO, 'Parroquia', 'parroquia_id'),
                )
        );
    }

}
