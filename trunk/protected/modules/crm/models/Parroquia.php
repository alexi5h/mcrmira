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
            array('provincia_id', 'safe', 'on' => 'search'),
        ));
    }

    public function searchParams() {
        return array(
//            'id', 
            'nombre',
            'canton_id',
            'provincia_id',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->join = ' INNER JOIN canton c ON c.id=t.canton_id';
        $criteria->join .= ' INNER JOIN provincia p ON p.id=c.provincia_id';
        $criteria->compare('t.id', $this->id, true, 'OR');
        $criteria->compare('t.nombre', $this->nombre, true, 'OR');
        $criteria->compare('c.nombre', $this->canton_id, true, 'OR');
        $criteria->compare('p.nombre', $this->provincia_id, true, 'OR');


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
