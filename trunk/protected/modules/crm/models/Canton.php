<?php

Yii::import('crm.models._base.BaseCanton');

class Canton extends BaseCanton {

    /**
     * @return Canton
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Canton|Cantons', $n);
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
                )
        );
    }

}
