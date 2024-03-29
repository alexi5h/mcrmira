<?php

/**
 * This is the model base class for the table "credito".
 * DO NOT MODIFY THIS FILE! It is automatically generated by AweCrud.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Credito".
 *
 * Columns in table "credito" available as properties of the model,
 * followed by relations of table "credito" available as properties of the model.
 *
 * @property integer $id
 * @property integer $socio_id
 * @property integer $garante_id
 * @property integer $sucursal_id
 * @property string $fecha_credito
 * @property string $fecha_limite
 * @property string $cantidad_total
 * @property string $total_pagar
 * @property string $cuota_capital
 * @property string $interes
 * @property string $total_interes
 * @property string $estado
 * @property integer $periodos
 * @property string $saldo_contra
 * @property string $saldo_favor
 * @property string $anulado
 * @property integer $usuario_creacion_id
 * @property string $numero_cheque
 *
 * @property CreditoAmortizacion[] $creditoAmortizacions
 * @property CreditoDeposito[] $creditoDepositos
 */
abstract class BaseCredito extends AweActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'credito';
    }

    public static function representingColumn() {
        return 'fecha_credito';
    }

    public function rules() {
        return array(
            array('socio_id, garante_id, sucursal_id, fecha_credito, cantidad_total, total_pagar, cuota_capital, interes, total_interes, estado, periodos, usuario_creacion_id, numero_cheque', 'required'),
            array('socio_id, garante_id, sucursal_id, periodos, usuario_creacion_id', 'numerical', 'integerOnly'=>true),
            array('cantidad_total, total_pagar, cuota_capital, total_interes, saldo_contra, saldo_favor', 'length', 'max'=>10),
            array('interes', 'length', 'max'=>3),
            array('estado', 'length', 'max'=>6),
            array('anulado', 'length', 'max'=>2),
            array('numero_cheque', 'length', 'max'=>45),
            array('fecha_limite', 'safe'),
            array('estado', 'in', 'range' => array('DEUDA','PAGADO')), // enum,
            array('anulado', 'in', 'range' => array('SI','NO')), // enum,
            array('fecha_limite, saldo_contra, saldo_favor, anulado', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, socio_id, garante_id, sucursal_id, fecha_credito, fecha_limite, cantidad_total, total_pagar, cuota_capital, interes, total_interes, estado, periodos, saldo_contra, saldo_favor, anulado, usuario_creacion_id, numero_cheque', 'safe', 'on'=>'search'),
        );
    }

    public function relations() {
        return array(
            'creditoAmortizacions' => array(self::HAS_MANY, 'CreditoAmortizacion', 'credito_id'),
            'creditoDepositos' => array(self::HAS_MANY, 'CreditoDeposito', 'credito_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'id' => Yii::t('app', 'ID'),
                'socio_id' => Yii::t('app', 'Socio'),
                'garante_id' => Yii::t('app', 'Garante'),
                'sucursal_id' => Yii::t('app', 'Sucursal'),
                'fecha_credito' => Yii::t('app', 'Fecha Credito'),
                'fecha_limite' => Yii::t('app', 'Fecha Limite'),
                'cantidad_total' => Yii::t('app', 'Cantidad Total'),
                'total_pagar' => Yii::t('app', 'Total Pagar'),
                'cuota_capital' => Yii::t('app', 'Cuota Capital'),
                'interes' => Yii::t('app', 'Interes'),
                'total_interes' => Yii::t('app', 'Total Interes'),
                'estado' => Yii::t('app', 'Estado'),
                'periodos' => Yii::t('app', 'Periodos'),
                'saldo_contra' => Yii::t('app', 'Saldo Contra'),
                'saldo_favor' => Yii::t('app', 'Saldo Favor'),
                'anulado' => Yii::t('app', 'Anulado'),
                'usuario_creacion_id' => Yii::t('app', 'Usuario Creacion'),
                'numero_cheque' => Yii::t('app', 'Numero Cheque'),
                'creditoAmortizacions' => null,
                'creditoDepositos' => null,
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('socio_id', $this->socio_id);
        $criteria->compare('garante_id', $this->garante_id);
        $criteria->compare('sucursal_id', $this->sucursal_id);
        $criteria->compare('fecha_credito', $this->fecha_credito, true);
        $criteria->compare('fecha_limite', $this->fecha_limite, true);
        $criteria->compare('cantidad_total', $this->cantidad_total, true);
        $criteria->compare('total_pagar', $this->total_pagar, true);
        $criteria->compare('cuota_capital', $this->cuota_capital, true);
        $criteria->compare('interes', $this->interes, true);
        $criteria->compare('total_interes', $this->total_interes, true);
        $criteria->compare('estado', $this->estado, true);
        $criteria->compare('periodos', $this->periodos);
        $criteria->compare('saldo_contra', $this->saldo_contra, true);
        $criteria->compare('saldo_favor', $this->saldo_favor, true);
        $criteria->compare('anulado', $this->anulado, true);
        $criteria->compare('usuario_creacion_id', $this->usuario_creacion_id);
        $criteria->compare('numero_cheque', $this->numero_cheque, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors() {
        return array_merge(array(
        ), parent::behaviors());
    }
}