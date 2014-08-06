<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CampoRuc extends CValidator {

    protected function validateAttribute($object, $attribute) {
        $nruc = $object->$attribute;
        $value = substr($nruc, 0, 10);
        $f = substr($nruc, 10, 3);
        if (!empty($nruc)) {
            if (strlen($nruc) == 13) {
                if ($f == '001') {
                } else {
                    $this->addError($object, $attribute, 'RUC no válido (últimos 3 dígitos deben ser 001)');
                }
            } else {
                $this->addError($object, $attribute, 'RUC tiene un largo incorrecto (debe ser de 13 caracteres)');
            }
        }
    }

}

?>