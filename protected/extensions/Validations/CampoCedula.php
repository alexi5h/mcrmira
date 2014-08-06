<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CampoCedula extends CValidator {

    protected function validateAttribute($object, $attribute) {
        $ncedula = $object->$attribute;
        $c = substr($ncedula, 0, 2);
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
                        $this->addError($object, $attribute, 'Número de cédula no válido (el último dígito no es correcto)!');
                    }
                } else {
                    $this->addError($object, $attribute, 'Número de cédula no válido (el 3er dígito debe ser menor a 6)');
                }
            } else {
                $this->addError($object, $attribute, 'Número de cédula no válido (verifique los primeros 2 dígitos)');
            }
        } else {
            $this->addError($object, $attribute, 'Cédula tiene un largo incorrecto (debe ser de 10 caracteres)');
        }
    }
}

?>