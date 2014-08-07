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
            array('provincia_id,canton_id', 'safe', 'on' => 'search'),
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'provincia_id' => Yii::t('app', 'Provincia'),
            'canton_id' => Yii::t('app', 'Cantón'),
        ));
    }

    public function searchParams() {
        return array(
//            'id', 
            'nombre',
            'parroquia_id',
            'canton_id',
            'provincia_id',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->join = ' INNER JOIN parroquia pa ON pa.id=t.parroquia_id';
        $criteria->join .= ' INNER JOIN canton c ON c.id=pa.canton_id';
        $criteria->join .= ' INNER JOIN provincia p ON p.id=c.provincia_id';
        $criteria->compare('t.id', $this->id, true, 'OR');
        $criteria->compare('t.nombre', $this->nombre, true, 'OR');
        $criteria->compare('p.nombre', $this->provincia_id, true, 'OR');
        $criteria->compare('c.nombre', $this->canton_id, true, 'OR');
        $criteria->compare('pa.nombre', $this->parroquia_id, true, 'OR');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
