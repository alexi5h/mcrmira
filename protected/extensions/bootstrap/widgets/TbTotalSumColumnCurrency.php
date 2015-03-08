<?php

Yii::import('bootstrap.widgets.TbTotalSumColumn');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TbTotalSumColumnCurrency
 *
 * @author Alexis_H
 */
class TbTotalSumColumnCurrency extends TbTotalSumColumn {

    protected function renderDataCellContent($row, $data) {
        ob_start();
        parent::renderDataCellContent($row, $data);
        $value = ob_get_clean();
        $formatted_value = $this->toInt($value);
        if (is_numeric($formatted_value)) {
            $this->total += $formatted_value;
        }
        echo $value;
    }

    protected function renderFooterCellContent() {
        if (is_null($this->total))
            return parent::renderFooterCellContent();

        echo $this->totalValue ? '$' . $this->evaluateExpression($this->totalValue, array('total' => number_format($this->total), 2, '.', ',')) : '$' . $this->grid->getFormatter()->format(number_format($this->total, 2, '.', ','), $this->type);
    }

    function toInt($str) {
        return preg_replace("/([^0-9\\.])/i", "", $str);
    }

}
