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

    public function rules() {
        return array_merge(parent::rules(), array(
            array('provincia_id,canton_id', 'required'),
            array('provincia_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'Elija una provincia por favor.',
            ),
            array('canton_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'Elija un cantón por favor.',
            ),
            array('parroquia_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'Elija un parroquia por favor.',
            ),
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'provincia_id' => Yii::t('app', 'Provincia'),
            'canton_id' => Yii::t('app', 'Cantón'),
        ));
    }

}
