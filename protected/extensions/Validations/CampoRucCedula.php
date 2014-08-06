<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CampoRucCedula extends CCompareValidator {

    protected function validateAttribute($object, $attribute) {
        $value = $object->$attribute;

        if (!empty($value)) {
            $value = substr($value, 0, 10);
            if ($this->compareValue !== null)
                $compareTo = $compareValue = $this->compareValue;
            else {
                $compareAttribute = $this->compareAttribute === null ? $attribute . '_repeat' : $this->compareAttribute;
                $compareValue = $object->$compareAttribute;
                $compareTo = $object->getAttributeLabel($compareAttribute);
            }
            switch ($this->operator) {
                case '==':
                    if (($this->strict && $value !== $compareValue) || (!$this->strict && $value != $compareValue))
                        $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} no válido (el número no coincide con su cédula)');
                    break;
                default:
                    throw new CException(Yii::t('yii', 'Invalid operator "{operator}".', array('{operator}' => $this->operator)));
            }
            if (!empty($message))
                $this->addError($object, $attribute, $message, array('{compareAttribute}' => $compareTo, '{compareValue}' => $compareValue));
        }
    }

}

?>