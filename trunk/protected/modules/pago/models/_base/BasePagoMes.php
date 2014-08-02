<?php

/**
 * This is the model base class for the table "pago_mes".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PagoMes".
 *
 * Columns in table "pago_mes" available as properties of the model,
 * followed by relations of table "pago_mes" available as properties of the model.
 *
 * @property integer $id
 * @property string $descripcion
 * @property integer $cliente_id
 * @property string $cantidad
 * @property string $fecha
 * @property string $estado
 *
 * @property Deposito[] $depositos
 */
abstract class BasePagoMes extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'pago_mes';
    }

    public static function representingColumn() {
        return 'descripcion';
    }

    public function rules() {
        return array(
            array('id, descripcion, cliente_id, cantidad, fecha, estado', 'required'),
            array('id, cliente_id', 'numerical', 'integerOnly'=>true),
            array('descripcion', 'length', 'max'=>100),
            array('cantidad', 'length', 'max'=>5),
            array('estado', 'length', 'max'=>6),
            array('estado', 'in', 'range' => array('DEUDA','PAGADO')), // enum,
            array('id, descripcion, cliente_id, cantidad, fecha, estado', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'depositos' => array(self::HAS_MANY, 'Deposito', 'pago_mes_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'descripcion' => Yii::t('app', 'Descripcion'),
                'cliente_id' => Yii::t('app', 'Cliente'),
                'cantidad' => Yii::t('app', 'Cantidad'),
                'fecha' => Yii::t('app', 'Fecha'),
                'estado' => Yii::t('app', 'Estado'),
                'depositos' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('descripcion', $this->descripcion, true);
        $criteria->compare('cliente_id', $this->cliente_id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('fecha', $this->fecha, true);
        $criteria->compare('estado', $this->estado, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}