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
            array('nombre, provincia_id', 'required', 'on' => 'insert,update'),
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

    public function getListSelect2($search_value=null){
        $command = Yii::app()->db->createCommand()
            ->select("p.id as id,
            p.nombre as text")
            ->from('canton p');
        if ($search_value) {
            $command->where("p.nombre like '$search_value%'");
        }
        $command->limit(10);
        return $command->queryAll();

    }

}
