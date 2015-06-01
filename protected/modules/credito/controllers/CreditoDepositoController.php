<?php

class CreditoDepositoController extends AweController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $admin = false;

    public function filters() {
        return array(
            array('CrugeAccessControlFilter'),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($credito_id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            $result = array();
            $model = new CreditoDeposito;
            $model->usuario_creacion_id = Yii::app()->user->id;
            $model->credito_id = $credito_id;
            $model->fecha_comprobante_su = Util::FechaActual();
            $model->cod_comprobante_su = CreditoDeposito::model()->generarCodigoComprobante($model->credito->socio_id);
            $this->performAjaxValidation($model, 'credito-deposito-form');
            $validadorPartial = true;
            if (isset($_POST['CreditoDeposito'])) {
                $modelCredito = Credito::model()->findByPk($model->credito_id);
                $modelAmortizacion = CreditoAmortizacion::model()->en_deuda()->de_credito($model->credito_id)->findAll();

                $model->attributes = $_POST['CreditoDeposito'];
                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');
                $model->cod_comprobante_su = CreditoDeposito::model()->generarCodigoComprobante($model->credito->socio_id);
                $result['cantidadExtra'] = 0;
                $condicion_devolucion = false;
                if ($model->cantidad + $model->interes <= $modelCredito->saldo_contra) {
                    $modelCredito->saldo_contra-=$model->cantidad;
                    $modelCredito->saldo_favor+=$model->cantidad;
//                    $cantidadTemp = $model->cantidad;
//                    $cont = 0;
//                    while ($cantidadTemp != 0) {
//                        $modelAmortizacionTemp = $modelAmortizacion[$cont];
//                        if ($cantidadTemp <= $modelAmortizacionTemp->saldo_contra) {
//                            $modelAmortizacionTemp->saldo_contra-=$cantidadTemp;
//                            $modelAmortizacionTemp->saldo_favor+=$cantidadTemp;
//                            if ($modelAmortizacionTemp->saldo_contra == 0) {
//                                $modelAmortizacionTemp->estado = CreditoAmortizacion::ESTADO_PAGADO;
//                            }
//                            $cantidadTemp = 0;
//                        } else {
//                            $cantidadTemp-=$modelAmortizacionTemp->saldo_contra;
//                            $modelAmortizacionTemp->saldo_contra = 0;
//                            $modelAmortizacionTemp->saldo_favor = $modelAmortizacionTemp->cuota;
//                            $modelAmortizacionTemp->estado = CreditoAmortizacion::ESTADO_PAGADO;
//                        }
//                        CreditoAmortizacion::model()->updateByPk($modelAmortizacionTemp->id, array(
//                            'estado' => $modelAmortizacionTemp->estado,
//                            'saldo_contra' => $modelAmortizacionTemp->saldo_contra,
//                            'saldo_favor' => $modelAmortizacionTemp->saldo_favor,
//                        ));
//                        $cont++;
//                    }
//                    $modelAmortizacionesComp = CreditoAmortizacion::model()->en_deuda()->de_credito($model->credito_id)->findAll();
//                    if (count($modelAmortizacionesComp) == 0) {
//                        $modelCredito->saldo_contra = 0;
//                        $modelCredito->saldo_favor = $modelCredito->total_pagar;
//                    }
                } else {
                    $result['cantidadExtra'] = $model->cantidad - $modelCredito->saldo_contra;
                    $result['socio_id'] = $modelCredito->socio_id;
                    $modelCredito->saldo_contra = 0;
                    $modelCredito->saldo_favor = $modelCredito->total_pagar;
//                    foreach ($modelAmortizacion as $amortizacion) {
//                        $amortizacion->estado = CreditoAmortizacion::ESTADO_PAGADO;
//                        $amortizacion->saldo_contra = 0;
//                        $amortizacion->saldo_favor = $amortizacion->cuota;
//                        CreditoAmortizacion::model()->updateByPk($amortizacion->id, array(
//                            'estado' => $amortizacion->estado,
//                            'saldo_contra' => $amortizacion->saldo_contra,
//                            'saldo_favor' => $amortizacion->saldo_favor,
//                        ));
//                    }
                    //Creación de un nuevo registro en credito_devolucion si existe una cantidad extra
                    $modelDevolucion = new CreditoDevolucion;
                    $modelDevolucion->cantidad = $result['cantidadExtra'];
                    $modelDevolucion->estado = CreditoDevolucion::ESTADO_NO_DEVUELTO;
                    $condicion_devolucion = true;
                    $result['message'] = 'Pago del crédito completo, la cantidad extra de valor $' . $result['cantidadExtra'] . ' se registró en Devoluciones de Crédito';
//                    $result['message'] = 'Pago del crédito completo';
                }
                if ($model->save()) {
                    $result['success'] = true;
                    $result['saldo_contra'] = $modelCredito->saldo_contra;
                    if ($modelCredito->saldo_contra == 0) {
                        $result['pagado'] = true;
                        $modelCredito->estado = Credito::ESTADO_PAGADO;
                    }
                    if ($condicion_devolucion) {
                        $modelDevolucion->credito_deposito_id = $model->id;
                        $modelDevolucion->save();
                    }
                    Credito::model()->updateByPk($model->credito_id, array(
                        'estado' => $modelCredito->estado,
                        'saldo_contra' => $modelCredito->saldo_contra,
                        'saldo_favor' => $modelCredito->saldo_favor,
                    ));
                } else {
                    $result['message'] = 'Error al guardar el depósito';
                }
                $validadorPartial = false;
                echo json_encode($result);
            }

            if ($validadorPartial) {
                $this->renderPartial('_form_modal_deposito', array(
                    'model' => $model,
                        ), false, true);
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'credito-deposito-form');

        if (isset($_POST['CreditoDeposito'])) {
            $model->attributes = $_POST['CreditoDeposito'];
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CreditoDeposito();
        $anio = Util::FormatDate(Util::FechaActual(), 'Y');
        $socio_id = null;
        $sucursal_id = Util::getSucursal();
        $model->sucursal_comprobante_id = $sucursal_id;
        if (isset($_GET['CreditoDeposito'])) {
            $anio = $_GET['CreditoDeposito']['anio'];
            $socio_id = $_GET['CreditoDeposito']['socio_id'];
            $sucursal_id = $_GET['CreditoDeposito']['sucursal_id'];
        }
        $data = $model->generarGridCreditoDepositos($socio_id, $sucursal_id, $anio);

        $this->render('admin', array(
            'model' => $model,
            'data' => $data,
            'anio' => $anio
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = CreditoDeposito::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'credito-deposito-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarDetalle() {
        $model = new CreditoDeposito;
        $anio = Util::FormatDate(Util::FechaActual(), 'Y');
        $socio_id = null;
        $sucursal_id = Util::getSucursal();
        $model->sucursal_comprobante_id = $sucursal_id;
        if (isset($_POST['CreditoDeposito'])) {

            $anio = $_POST['CreditoDeposito']['anio'];
            $anio_anterior = $anio - 1;
            $socio_id = $_POST['CreditoDeposito']['socio_id'];
            $sucursal_id = $_POST['CreditoDeposito']['sucursal_comprobante_id'];
            $reporte = $model->generarGridCreditoDepositos($socio_id, $sucursal_id, $anio);
            //genera el reporte de excel
            $objExcel = new PHPExcel();


            //carga la consulta en la hoja 0 con el contenido de la busqueda, empezando desde la seguna fila
//            $objExcel->setActiveSheetIndex(0)->fromArray($reporte, null, 'A2');
            //agrega las cabeceras
            $objExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', '#Cheque')
                    ->setCellValue('B1', 'Nombres')
                    ->setCellValue('C1', 'Fecha Crédito')
                    ->setCellValue('D1', 'Cantón')
                    ->setCellValue('E1', "Capital {$anio_anterior}")
                    ->setCellValue('F1', "Interés {$anio_anterior}")
                    ->setCellValue('G1', 'Capital Enero')
                    ->setCellValue('H1', 'Interes Enero')
                    ->setCellValue('I1', 'Multa Enero')
                    ->setCellValue('J1', 'Capital Febrero')
                    ->setCellValue('K1', 'Interes Febrero')
                    ->setCellValue('L1', 'Multa Febrero')
                    ->setCellValue('M1', 'Capital Marzo')
                    ->setCellValue('N1', 'Interes Marzo')
                    ->setCellValue('O1', 'Multa Marzo')
                    ->setCellValue('P1', 'Capital Abril')
                    ->setCellValue('Q1', 'Interes Abril')
                    ->setCellValue('R1', 'Multa Abril')
                    ->setCellValue('S1', 'Capital Mayo')
                    ->setCellValue('T1', 'Interes Mayo')
                    ->setCellValue('U1', 'Multa Mayo')
                    ->setCellValue('V1', 'Capital Junio')
                    ->setCellValue('W1', 'Interes Junio')
                    ->setCellValue('X1', 'Multa Junio')
                    ->setCellValue('Y1', 'Capital Julio')
                    ->setCellValue('Z1', 'Interes Julio')
                    ->setCellValue('AA1', 'Multa Julio')
                    ->setCellValue('AB1', 'Capital Agosto')
                    ->setCellValue('AC1', 'Interes Agosto')
                    ->setCellValue('AD1', 'Multa Agosto')
                    ->setCellValue('AE1', 'Capital Septiembre')
                    ->setCellValue('AF1', 'Interes Septiembre')
                    ->setCellValue('AG1', 'Multa Septiembre')
                    ->setCellValue('AH1', 'Capital Octubre')
                    ->setCellValue('AI1', 'Interes Octubre')
                    ->setCellValue('AJ1', 'Multa Octubre')
                    ->setCellValue('AK1', 'Capital Noviembre')
                    ->setCellValue('AL1', 'Interes Noviembre')
                    ->setCellValue('AM1', 'Multa Noviembre')
                    ->setCellValue('AN1', 'Capital Diciembre')
                    ->setCellValue('AO1', 'Interes Diciembre')
                    ->setCellValue('AP1', 'Multa Diciembre');
            $id = 2;
            foreach ($reporte as $r) {
                $objExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $id, $r['numero_cheque'])
                        ->setCellValue('B' . $id, $r['Nombres'])//Titulo de las columnas
                        ->setCellValue('C' . $id, $r['fecha_credito'])
                        ->setCellValue('D' . $id, $r['Sucursal'])
                        ->setCellValue('E' . $id, $r['pagos_ant'])
                        ->setCellValue('F' . $id, $r['interes_ant'])
                        ->setCellValue('G' . $id, $r['Enero'])
                        ->setCellValue('H' . $id, $r[0]['Enero'])
                        ->setCellValue('I' . $id, $r[1]['Enero'])
                        ->setCellValue('J' . $id, $r['Febrero'])
                        ->setCellValue('K' . $id, $r[0]['Febrero'])
                        ->setCellValue('L' . $id, $r[1]['Febrero'])
                        ->setCellValue('M' . $id, $r['Marzo'])
                        ->setCellValue('N' . $id, $r[0]['Marzo'])
                        ->setCellValue('O' . $id, $r[1]['Marzo'])
                        ->setCellValue('P' . $id, $r['Abril'])
                        ->setCellValue('Q' . $id, $r[0]['Abril'])
                        ->setCellValue('R' . $id, $r[1]['Abril'])
                        ->setCellValue('S' . $id, $r['Mayo'])
                        ->setCellValue('T' . $id, $r[0]['Mayo'])
                        ->setCellValue('U' . $id, $r[1]['Mayo'])
                        ->setCellValue('V' . $id, $r['Junio'])
                        ->setCellValue('W' . $id, $r[0]['Junio'])
                        ->setCellValue('X' . $id, $r[1]['Junio'])
                        ->setCellValue('Y' . $id, $r['Julio'])
                        ->setCellValue('Z' . $id, $r[0]['Julio'])
                        ->setCellValue('AA' . $id, $r[1]['Julio'])
                        ->setCellValue('AB' . $id, $r['Agosto'])
                        ->setCellValue('AC' . $id, $r[0]['Agosto'])
                        ->setCellValue('AD' . $id, $r[1]['Agosto'])
                        ->setCellValue('AE' . $id, $r['Septiembre'])
                        ->setCellValue('AF' . $id, $r[0]['Septiembre'])
                        ->setCellValue('AG' . $id, $r[1]['Septiembre'])
                        ->setCellValue('AH' . $id, $r['Octubre'])
                        ->setCellValue('AI' . $id, $r[0]['Octubre'])
                        ->setCellValue('AJ' . $id, $r[1]['Octubre'])
                        ->setCellValue('AK' . $id, $r['Noviembre'])
                        ->setCellValue('AL' . $id, $r[0]['Noviembre'])
                        ->setCellValue('AM' . $id, $r[1]['Noviembre'])
                        ->setCellValue('AN' . $id, $r['Diciembre'])
                        ->setCellValue('AO' . $id, $r[0]['Diciembre'])
                        ->setCellValue('AP' . $id, $r[1]['Diciembre'])
                ;
                $id++;
            }

            for ($i = 'A'; $i <= 'Z'; $i++) {
                $objExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
            }
//titulo de la hoja 0
            $objExcel->getActiveSheet()->setTitle('Depositos');

//// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
            $objExcel->setActiveSheetIndex(0);
//// Inmovilizar paneles
            $objExcel->getActiveSheet(0)->freezePane('A2');
//                $objExcel->getActiveSheet(0)->freezePaneByColumnAndRow(1, 2);
// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//crea el archivo con el siguiente formato: Incidencias <fecha inicial> hasta <fecha final>.xlsx
            header('Content-Disposition: attachment;filename="Consolidado.xlsx"');
            header('Cache-Control: max-age=0');
//genera el archivo con formato excel 2007
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');

            $objWriter->save('php://output');

//        exit();
        }
    }

}
