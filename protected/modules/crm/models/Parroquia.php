<?php

Yii::import('crm.models._base.BaseParroquia');

class Parroquia extends BaseParroquia {

    public $provincia_id;

    /**
     * @return Parroquia
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Parroquia|Parroquias', $n);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'provincia_id' => Yii::t('app', 'Provincia'),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
                )
        );
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('provincia_id', 'required'),
            array('provincia_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'Elija una provincia por favor.',
            ),
            array('canton_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'Elija un canton por favor.',
            ),
        ));
    }

}
