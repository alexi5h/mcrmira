<?php

class CreditoController extends AweController {

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
    public function actionCreate() {
        $model = new Credito;

        $this->performAjaxValidation($model, 'credito-form');

        if (isset($_POST['Credito'])) {
            $model->attributes = $_POST['Credito'];
            $model->fecha_credito = Util::FormatDate($model->fecha_credito, 'Y-m-d H:i:s');
            $model->estado = Credito::ESTADO_DEUDA;
            $model->interes = Credito::INTERES;

            //Fecha límite temporal
            $model->fecha_limite = Util::FechaActual();

            //Cálculo de amortización
            $info_Amortizacion = Util::calculo_amortizacion($model->cantidad_total, $model->interes, $model->periodos, $model->fecha_credito);
            $model->total_pagar = $info_Amortizacion['suma_cuota'];
            $model->total_interes = $info_Amortizacion['suma_interes'];
            $model->saldo_contra = $model->total_pagar;
            $model->saldo_favor = 0;
            $model->anulado = Credito::NO_ANULADO;

            $tabla = $info_Amortizacion['tabla'];
            if ($model->save()) {
                for ($i = 0; $i < count($tabla); $i++) {
                    $modelAmort = new CreditoAmortizacion;
                    $modelAmort->nro_cuota = $tabla[$i]['nro_cuota'];
                    $modelAmort->fecha_pago = $tabla[$i]['fecha_pago'];
                    $modelAmort->cuota = $tabla[$i]['cuota'];
                    $modelAmort->interes = $tabla[$i]['interes'];
                    $modelAmort->amortizacion = $tabla[$i]['amortizacion'];
                    $modelAmort->estado = Credito::ESTADO_DEUDA;
                    $modelAmort->saldo_contra = $modelAmort->cuota;
                    $modelAmort->saldo_favor = 0;
                    $modelAmort->credito_id = $model->id;
                    $modelAmort->save();
                }
                $model->fecha_limite = $modelAmort->fecha_pago;
                $model->save();
                $this->redirect(array('admin'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'credito-form');

        if (isset($_POST['Credito'])) {
            $model->attributes = $_POST['Credito'];
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
        $model = new Credito('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Credito'])) {
//            $model->attributes = $_GET['Credito'];
            $model->de_numeros_cheque($_GET['Credito']['numero_cheque']);
            $model->de_socios($_GET['Credito']['socio_id']);
            $model->de_sucursales($_GET['Credito']['sucursal_id']);
            if ($_GET['Credito']['ano_creacion'] && $_GET['Credito']['mes_creacion']) {
                $fechas = array();
                $array_meses = explode(',', $_GET['Credito']['mes_creacion']);
                foreach ($array_meses as $value) {
                    array_push($fechas, '"' . $_GET['Credito']['ano_creacion'] . '/' . $value . '"');
                }
                $model->de_fechas($_GET['Credito']['ano_creacion'], $_GET['Credito']['mes_creacion'], implode(',', $fechas));
            } else {
                $model->de_fechas($_GET['Credito']['ano_creacion'], $_GET['Credito']['mes_creacion']);
            }
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = Credito::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'credito-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxlistCreditos($socio_ids = null, $search_value = null) {
        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(Credito::model()->getListSelect2($socio_ids, $search_value));
        }
    }

    public function actionExportarCredito() {
        $model = new Credito;
        if (isset($_POST['Credito'])) {
//            $parametros = $_POST['Credito'];

            $model->de_socios($_POST['Credito']['socio_id']);
            $model->de_numeros_cheque($_POST['Credito']['numero_cheque']);
            $model->de_sucursales($_POST['Credito']['sucursal_id']);
            if ($_POST['Credito']['ano_creacion'] && $_POST['Credito']['mes_creacion']) {
                $fechas = array();
                $array_meses = explode(',', $_POST['Credito']['mes_creacion']);
                foreach ($array_meses as $value) {
                    array_push($fechas, '"' . $_POST['Credito']['ano_creacion'] . '/' . $value . '"');
                }
                $model->de_fechas($_POST['Credito']['ano_creacion'], $_POST['Credito']['mes_creacion'], implode(',', $fechas));
            } else {
                $model->de_fechas($_POST['Credito']['ano_creacion'], $_POST['Credito']['mes_creacion']);
            }
            $reporte = $model->findAll();

            //genera el reporte de excel
            $objExcel = new PHPExcel();


            //carga la consulta en la hoja 0 con el contenido de la busqueda, empezando desde la seguna fila
//            $objExcel->setActiveSheetIndex(0)->fromArray($model, null, 'A2');
            //agrega las cabeceras 
            $objExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Socio')
                    ->setCellValue('B1', 'Garante')
                    ->setCellValue('C1', 'Sucursal')
                    ->setCellValue('D1', 'Fecha Crédito')
                    ->setCellValue('E1', 'Fecha límite')
                    ->setCellValue('F1', 'Interés (%)')
                    ->setCellValue('G1', 'Cantidad Total ($)')
                    ->setCellValue('H1', 'Total a Pagar ($)')
                    ->setCellValue('I1', 'Total Intereses ($)')
                    ->setCellValue('J1', 'Periodos')
                    ->setCellValue('K1', 'Saldo en contra ($)')
                    ->setCellValue('L1', 'Saldo a favor ($)')
                    ->setCellValue('M1', 'Anulado')
                    ->setCellValue('N1', 'Número de Cheque')
                    ->setCellValue('O1', 'Estado');

            $id = 2;
            foreach ($reporte as $campo) {
                $objExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $id, $campo->socio->nombre_formato)
                        ->setCellValue('B' . $id, $campo->garante->nombre_formato)
                        ->setCellValue('C' . $id, $campo->sucursal->nombre)
                        ->setCellValue('D' . $id, Util::FormatDate($campo->fecha_credito, 'd/m/Y'))
                        ->setCellValue('E' . $id, Util::FormatDate($campo->fecha_limite, 'd/m/Y'))
                        ->setCellValue('F' . $id, $campo->interes)
                        ->setCellValue('G' . $id, round($campo->cantidad_total,2))
                        ->setCellValue('H' . $id, round($campo->total_pagar,2))
                        ->setCellValue('I' . $id, round($campo->total_interes,2))
                        ->setCellValue('J' . $id, $campo->periodos)
                        ->setCellValue('K' . $id, $campo->saldo_contra)
                        ->setCellValue('L' . $id, $campo->saldo_favor)
                        ->setCellValue('M' . $id, $campo->anulado)
                        ->setCellValue('N' . $id, $campo->numero_cheque)
                        ->setCellValue('O' . $id, $campo->estado)
                ;
                $id++;
            }

            for ($i = 'A'; $i <= 'Z'; $i++) {
                $objExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
            }
//titulo de la hoja 0
            $objExcel->getActiveSheet()->setTitle('Créditos');

//// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
            $objExcel->setActiveSheetIndex(0);
//// Inmovilizar paneles
            $objExcel->getActiveSheet(0)->freezePane('A2');
//                $objExcel->getActiveSheet(0)->freezePaneByColumnAndRow(1, 2);
// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//crea el archivo con el siguiente formato: Incidencias <fecha inicial> hasta <fecha final>.xlsx
            header('Content-Disposition: attachment;filename="Reporte de Créditos.xlsx"');
            header('Cache-Control: max-age=0');
//genera el archivo con formato excel 2007
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');

            $objWriter->save('php://output');

//        exit();
        }
    }

}
