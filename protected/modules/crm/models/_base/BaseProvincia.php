<?php

/**
 * This is the model base class for the table "provincia".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Provincia".
 *
 * Columns in table "provincia" available as properties of the model,
 * followed by relations of table "provincia" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Canton[] $cantons
 */
abstract class BaseProvincia extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'provincia';
    }

    public static function representingColumn() {
        return 'nombre';
    }

    public function rules() {
        return array(
            array('nombre', 'required'),
            array('nombre', 'length', 'max'=>21),
            array('id, nombre', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'cantons' => array(self::HAS_MANY, 'Canton', 'provincia_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'nombre' => Yii::t('app', 'Nombre'),
                'cantons' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nombre', $this->nombre, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}