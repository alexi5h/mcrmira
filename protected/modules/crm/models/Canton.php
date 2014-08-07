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
        return Yii::t('app', 'Cantón|Cantones', $n);
    }

    public function rules() {
        return array(
            array('nombre, provincia_id', 'required'),
            array('provincia_id', 'numerical',
                'integerOnly' => true,
                'min' => 1,
                'tooSmall' => 'No hay Provincias.',
            ),
            array('provincia_id', 'numerical', 'integerOnly' => true),
            array('nombre', 'length', 'max' => 45),
            array('id, nombre, provincia_id', 'safe', 'on' => 'search'),
        );
    }

    public function searchParams() {
        return array(
            'nombre',
            'provincia_id',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('provincia');

        $criteria->compare('t.id', $this->id, true, 'OR');
        $criteria->compare('t.nombre', $this->nombre, true, 'OR');
//        $criteria->compare('provincia_id', $this->provincia_id, true, 'OR');
        $criteria->compare('provincia.nombre', $this->provincia_id, true, 'OR');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
