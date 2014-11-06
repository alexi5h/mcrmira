<?php

Yii::import('ahorro.models._base.BaseAhorroRetiro');

class AhorroRetiro extends BaseAhorroRetiro
{

//    const TIPO_AHORRO_OBIGATORIO = 'OBLIGATORIO';
//    const TIPO_AHORRO_VOLUNTARIO = 'VOLUNTARIO';

    public $tipoAhorro;

    /**
     * @return AhorroRetiro
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Retiro|Retiros', $n);
    }

    public function relations()
    {
        return array(
            'socio' => array(self::BELONGS_TO, 'Persona', 'socio_id'),
            'sucursal' => array(self::BELONGS_TO, 'Sucursal', 'sucursal_id'),
            'entidadBancaria' => array(self::BELONGS_TO, 'EntidadBancaria', 'entidad_bancaria_id'),
        );
    }

    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('tipoAhorro', 'required', 'message' => 'Seleccione un tipo de ahorro.',),
            array('cantidad', 'numerical', 'min' => 1, 'tooSmall' => 'La cantidad debe ser mayor a 0'),
        ));
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'socio_id' => Yii::t('app', 'Socio'),
            'sucursal_id' => Yii::t('app', 'Sucursal'),
            'cantidad' => Yii::t('app', 'Cantidad'),
            'tipoAhorro' => Yii::t('app', 'Tipo Ahorro'),
            'fecha_retiro' => Yii::t('app', 'Fecha Retiro'),
            'comprobante_retiro' => Yii::t('app', 'Comprobante Retiro'),
            'entidad_bancaria_id' => Yii::t('app', 'Entidad Bancaria'),
        );
    }

    public function beforeSave()
    {
        $this->fecha_retiro = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_id = Util::getSucursal();
        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        $this->fecha_retiro = Util::FechaActual();
        $this->usuario_creacion_id = Yii::app()->user->id;
        $this->sucursal_id = Util::getSucursal();
        return parent::beforeValidate();
    }

}
