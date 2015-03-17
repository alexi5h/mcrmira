<?php

Yii::import('ahorro.models._base.BaseAhorroDeposito');

class AhorroDeposito extends BaseAhorroDeposito {

    /**
     * @return AhorroDeposito
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array_merge(parent::rules(), array(
//            array('cantidad', 'numerical', 'integerOnly' => false, 'max' => $this->ahorro->saldo_contra),
            array('socio_id', 'required'),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'entidadBancaria' => array(self::BELONGS_TO, 'EntidadBancaria', 'entidad_bancaria_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_comprobante_id'),
            'socio' => array(self::BELONGS_TO, 'Persona', 'socio_id'),
        ));
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Deposito|Depositos', $n);
    }

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
            'usuario_creacion_id' => Yii::t('app', 'Usuario Creacion'),
            'socio_id' => Yii::t('app', 'Socio'),
        );
    }

    public function beforeSave() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate() {
        $this->fecha_comprobante_su = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_comprobante_id = Util::getSucursal();
        return parent::beforeValidate();
    }

    public function searchByAhorro($id_ahorro) {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('cantidad', $this->cantidad, true);
        $criteria->compare('entidad_bancaria_id', $this->entidad_bancaria_id);
        $criteria->compare('cod_comprobante_entidad', $this->cod_comprobante_entidad, true);
        $criteria->compare('fecha_comprobante_entidad', $this->fecha_comprobante_entidad, true);
        $criteria->compare('sucursal_comprobante_id', $this->sucursal_comprobante_id);
        $criteria->compare('cod_comprobante_su', $this->cod_comprobante_su, true);
        $criteria->compare('fecha_comprobante_su', $this->fecha_comprobante_su, true);
//        $criteria->compare('ahorro_id', $id_ahorro);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));
    }

    public function totalDepositosByPago($id_ahorro) {
//        select sum(t.cantidad) from deposito t where t.pago_id=1;
        $consulata = Yii::app()->db->createCommand()->
                select('sum(t.cantidad) as total_depositos_pago')->
                from('ahorro_deposito t')->
                where('t.pago_id=:pago_id');
        $consulata->params = array(':pago_id' => $id_ahorro);

        return $consulata->queryAll();
    }

    public function searchDepositosSocio($socio_id = null) {
        $criteria = new CDbCriteria;
        $sort = new CSort;
//        $criteria->with = array('ahorro');
        $criteria->addCondition('t.socio_id=:socio_id', 'AND');
//        $criteria->mergeWith(CreditoDeposito::model()->searchDepositosSocio($socio_id));
//        $criteria->addCondition('t.id not in (select ev.cuenta_id from evento_visita ev where ev.estado=:ev_estado)', 'AND');
//        $criteria->addCondition('(t.frecuencia is not null OR t.frecuencia>0)', 'AND');

        $params = array(
            ':socio_id' => $socio_id,
        );
        $criteria->params = array_merge($criteria->params, $params);
        /* Sort criteria */

        $sort->attributes = array(
            'fecha_comprobante_su' => array(
                'asc' => 't.fecha_comprobante_su asc',
                'desc' => 't.fecha_comprobante_su desc',
            ),
            '*',
        );
        $sort->defaultOrder = 't.fecha_comprobante_su asc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, 'sort' => $sort,
            'pagination'=>false
        ));
    }

    public function generarCodigoComprobante($socio_id = '') {
        $result = date('y') . date('m') . date('d') . date('H') . date('i') . date('s') . $socio_id;
        return $result;
    }

}
