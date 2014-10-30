<?php

/**
 * This is the model base class for the table "credito_deposito".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CreditoDeposito".
 *
 * Columns in table "credito_deposito" available as properties of the model,
 * followed by relations of table "credito_deposito" available as properties of the model.
 *
 * @property integer $id
 * @property string $cantidad
 * @property integer $entidad_bancaria_id
 * @property string $cod_comprobante_entidad
 * @property string $fecha_comprobante_entidad
 * @property integer $sucursal_comprobante_id
 * @property string $cod_comprobante_su
 * @property string $fecha_comprobante_su
 * @property string $observaciones
 * @property integer $credito_id
 * @property integer $usuario_creacion_id
 *
 * @property Credito $credito
 */
abstract class BaseCreditoDeposito extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'credito_deposito';
    }

    public static function representingColumn() {
        return 'cantidad';
    }

    public function rules() {
        return array(
            array('cantidad, entidad_bancaria_id, cod_comprobante_entidad, fecha_comprobante_entidad, sucursal_comprobante_id, cod_comprobante_su, fecha_comprobante_su, credito_id, usuario_creacion_id', 'required'),
            array('entidad_bancaria_id, sucursal_comprobante_id, credito_id, usuario_creacion_id', 'numerical', 'integerOnly'=>true),
            array('cantidad', 'length', 'max'=>10),
            array('cod_comprobante_entidad, cod_comprobante_su', 'length', 'max'=>45),
            array('observaciones', 'safe'),
            array('observaciones', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, cantidad, entidad_bancaria_id, cod_comprobante_entidad, fecha_comprobante_entidad, sucursal_comprobante_id, cod_comprobante_su, fecha_comprobante_su, observaciones, credito_id, usuario_creacion_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'credito' => array(self::BELONGS_TO, 'Credito', 'credito_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'cantidad' => Yii::t('app', 'Cantidad'),
                'entidad_bancaria_id' => Yii::t('app', 'Entidad Bancaria'),
                'cod_comprobante_entidad' => Yii::t('app', 'Cod Comprobante Entidad'),
                'fecha_comprobante_entidad' => Yii::t('app', 'Fecha Comprobante Entidad'),
                'sucursal_comprobante_id' => Yii::t('app', 'Sucursal Comprobante'),
                'cod_comprobante_su' => Yii::t('app', 'Cod Comprobante Su'),
                'fecha_comprobante_su' => Yii::t('app', 'Fecha Comprobante Su'),
                'observaciones' => Yii::t('app', 'Observaciones'),
                'credito_id' => Yii::t('app', 'Credito'),
                'usuario_creacion_id' => Yii::t('app', 'Usuario Creacion'),
                'credito' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
        $criteria->compare('observaciones', $this->observaciones, true);
        $criteria->compare('credito_id', $this->credito_id);
        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}