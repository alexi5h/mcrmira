<?php

/**
 * This is the model base class for the table "entidad_bancaria".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "EntidadBancaria".
 *
 * Columns in table "entidad_bancaria" available as properties of the model,
 * followed by relations of table "entidad_bancaria" available as properties of the model.
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $direccion_id
 *
 * @property Direccion $direccion
 */
abstract class BaseEntidadBancaria extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'entidad_bancaria';
    }

    public static function representingColumn() {
        return 'nombre';
    }

    public function rules() {
        return array(
            array('nombre, direccion_id', 'required'),
            array('direccion_id', 'numerical', 'integerOnly'=>true),
            array('nombre', 'length', 'max'=>45),
            array('id, nombre, direccion_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'direccion' => array(self::BELONGS_TO, 'Direccion', 'direccion_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'nombre' => Yii::t('app', 'Nombre'),
                'direccion_id' => Yii::t('app', 'Direccion'),
                'direccion' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nombre', $this->nombre, true);
        $criteria->compare('direccion_id', $this->direccion_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}