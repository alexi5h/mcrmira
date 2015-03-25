<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'consolidado-grid',
    'type' => 'striped bordered hover advance',
    'dataProvider' => new CArrayDataProvider($data, array('pagination' => false)),
    'columns' => array(
        array(
            'value' => '$data["Nombres"]',
            'type' => 'raw',
            'header' => 'Nombres'
        ),
        array(
            'value' => '$data["Cedula"]',
            'type' => 'raw',
            'header' => 'Cedula'
        ),
        array(
            'value' => '$data["Saldo"]',
            'type' => 'raw',
            'header' => 'Saldo'
        ),
        array(
            'value' => '$data["Enero"]',
            'type' => 'raw',
            'header' => 'Enero'
        ),
        array(
            'value' => '$data["Febrero"]',
            'type' => 'raw',
            'header' => 'Febrero'
        ),
        array(
            'value' => '$data["Marzo"]',
            'type' => 'raw',
            'header' => 'Marzo'
        ),
        array(
            'value' => '$data["Abril"]',
            'type' => 'raw',
            'header' => 'Abril'
        ),
        array(
            'value' => '$data["Mayo"]',
            'type' => 'raw',
            'header' => 'Mayo'
        ),
        array(
            'value' => '$data["Junio"]',
            'type' => 'raw',
            'header' => 'Junio'
        ),
        array(
            'value' => '$data["Julio"]',
            'type' => 'raw',
            'header' => 'Julio'
        ),
        array(
            'value' => '$data["Agosto"]',
            'type' => 'raw',
            'header' => 'Agosto'
        ),
        array(
            'value' => '$data["Septiembre"]',
            'type' => 'raw',
            'header' => 'Septiembre'
        ),
        array(
            'value' => '$data["Octubre"]',
            'type' => 'raw',
            'header' => 'Octubre'
        ),
        array(
            'value' => '$data["Noviembre"]',
            'type' => 'raw',
            'header' => 'Noviembre'
        ),
        array(
            'value' => '$data["Diciembre"]',
            'type' => 'raw',
            'header' => 'Diciembre'
        ),
        array(
            'value' => '$data["Total"]',
            'type' => 'raw',
            'header' => 'Total'
        ),
    ),
));
?>