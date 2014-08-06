<?php

Yii::import('crm.models._base.BaseDireccion');

class Direccion extends BaseDireccion {

    public $provincia_id;
    public $canton_id;

    const TIPO_SUCURSAL = 'S';
    const TIPO_CLIENTE = 'C';
    const TIPO_ENTIDAD_BANCARIA = 'E';

    private $direccion_completa;

    /**
     * @return Direccion
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Dirección|Direcciones', $n);
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('provincia_id,canton_id,parroquia_id', 'required', 'on' => 'register'),
        ));
    }

    public function getDireccion_completa() {
        if(!$this->direccion_completa){
            $calle1=  $this->calle_1 ? $this->calle_1 : '';
            $numero= $this->numero ? $this->numero : 's/n';
            $calle2= $this->calle_2 ? $this->calle_2 : '';
            $calle1y2= $calle1=='' ? ($calle2=='' ? '' : $calle2) : ($calle2=='' ? $calle1.' '.$numero : $calle1.' '.$numero.' y '.$calle2);
            $referencia= $this->referencia ? ', '.$this->referencia : '';
            $barrio=  $this->barrio ? ', '.$this->barrio : '';
            $parroquiaCantonProvincia=  $this->parroquia ? ' - '.$this->parroquia.' - '.$this->parroquia->canton.' - '.$this->parroquia->canton->provincia : '';
            
            $this->direccion_completa=$calle1y2.$referencia.$barrio.$parroquiaCantonProvincia;
            return $this->direccion_completa;
        }
    }

    public function setDireccion_completa($nombre_completo) {
        $this->direccion_completa = $nombre_completo;
        return $this->direccion_completa;
    }

}
