<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CampoCedula extends CValidator {

    public $tipo;

    protected function validateAttribute($object, $attribute) {
        $ncedula = $object->$attribute;
//        $tipo = $object->tipo_identificacion;
        $c = substr($ncedula, 0, 2);
//        if ($tipo == 'C') {
            if (strlen($ncedula) == 10) {
                if ($c >= '1' && $c <= '24') {//Pertenece a alguna provincia
                    if ($ncedula[2] < 6) {//3er dígito menor a 6
                        //Comprobar último dígito
                        $n = array(9);
                        $cont = 2;
                        $suma = 0;
                        for ($j = 0; $j < 9; $j++) {
                            if ($ncedula[$j] * $cont >= 10) {
                                $n[$j] = ($ncedula[$j] * $cont) - 9;
                            } else {
                                $n[$j] = $ncedula[$j] * $cont;
                            }
                            if ($cont == 1) {
                                $cont = 2;
                            } else {
                                $cont = 1;
                            }
                            $suma+=$n[$j];
                        }
                        $suma = $suma . '';
                        $last_digit;
                        if ($suma < 10) {
                            $last_digit = 10 - $suma;
                        } else {
                            if ($suma[1] == 0) {
                                $last_digit = 0;
                            } else {
                                $temp = ($suma[0] + 1) * 10;
                                $last_digit = $temp - $suma;
                            }
                        }
                        if ($last_digit == $ncedula[9]) {
                            
                        } else {
                            $this->addError($object, $attribute, 'Número de identificación no válido !');
                        }
                    } else {
                        $this->addError($object, $attribute, 'Número de identificación no válido (el 3er dígito debe ser menor a 6)');
                    }
                } else {
                    $this->addError($object, $attribute, 'Número de identificación no válido (verifique los primeros 2 dígitos)');
                }
            } else {
                $this->addError($object, $attribute, 'Su identificación tiene una longitud incorrecta (máximo 10 caracteres)');
            }
//        } elseif ($tipo == '') {
//            $this->addError($object, $attribute, 'Escoja un tipo de identificación');
//        }
    }

}

?>