<?php

Yii::import('crm.models._base.BaseParroquia');

class Parroquia extends BaseParroquia {

    /**
     * @return Parroquia
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Parroquia|Parroquias', $n);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'canton' => array(self::BELONGS_TO, 'Canton', 'canton_id'),
            'barrios' => array(self::HAS_MANY, 'Barrio', 'parroquia_id'),
                )
        );
    }

}
