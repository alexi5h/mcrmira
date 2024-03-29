<?php

class AhorroDepositoController extends AweController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'..
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

    public function actionCreateDeposito($socio_id = null) {
        $model = new AhorroDeposito();


        if (Yii::app()->request->isAjaxRequest) {
            $this->performAjaxValidation($model, 'ahorro-deposito-form');
            $result = array();
            if (isset($_POST['AhorroDeposito'])) {


                $model->attributes = $_POST['AhorroDeposito'];

                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');
                $model->fecha_comprobante_su = Util::FormatDate(Util::FechaActual(), 'Y-m-d H:i:s');
                $model->sucursal_comprobante_id = Persona::model()->findByPk($model->socio_id)->sucursal_id;
                $model->usuario_creacion_id = Yii::app()->user->id;
                $result['success'] = $model->save();

                echo json_encode($result);
                Yii::app()->end();
            }
            $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($socio_id);
            $model->socio_id = $socio_id;
            $model->sucursal_comprobante_id = Persona::model()->findByPk($socio_id)->sucursal_id;
            $this->renderPartial('_form_modal_deposito_ahorro', array(
                'model' => $model,
                    ), false, true);
        } else {
            $this->performAjaxValidation($model, 'ahorro-deposito-form');
            if (isset($_POST['AhorroDeposito'])) {

                $model->attributes = $_POST['AhorroDeposito'];
                $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->socio_id);
                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');
                $model->fecha_comprobante_su = Util::FormatDate(Util::FechaActual(), 'Y-m-d H:i:s');
                $model->sucursal_comprobante_id = Persona::model()->findByPk($model->socio_id)->sucursal_id;
                $model->usuario_creacion_id = Yii::app()->user->id;
                if ($model->save())
                    $this->redirect(array('admin'));
            }
            $this->render('create', array('model' => $model));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id_ahorro = null) {
        if (Yii::app()->request->isAjaxRequest) {// el deposito solo se lo puede hacer mediante un modal
            $result = array();
            $model = new AhorroDeposito;

            $model->ahorro_id = $id_ahorro;
            $modelAhorro = Ahorro::model()->findByPk($id_ahorro);
            $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->ahorro->socio_id);
            $this->performAjaxValidation($model, 'ahorro-deposito-form');

            if (isset($_POST['AhorroDeposito'])) {
                $result['ahorro_id'] = $model->ahorro_id;
                $model->attributes = $_POST['AhorroDeposito'];

                if ($model->cantidad <= $modelAhorro->saldo_contra) {// saber si se supera la cantidad
                    $modelAhorro->saldo_contra = $modelAhorro->saldo_contra - $model->cantidad;
                    $modelAhorro->saldo_favor = $modelAhorro->saldo_favor + $model->cantidad;
                    $result['cantidadExtra'] = 0;
                } else {
                    $modelAhorro->saldo_contra = 0;
                    $modelAhorro->saldo_favor = $modelAhorro->cantidad;
                }
                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');

                $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->ahorro->socio_id);
                $model->fecha_comprobante_su = Util::FechaActual();
                $result['enableButtonSave'] = true; // habilitado en boton para hacer depositos
                if ($model->save()) {
                    if ($modelAhorro->saldo_contra == 0) { // si el ahorro ya se pago en su totalidad
                        $modelAhorro->estado = Ahorro::ESTADO_PAGADO;
                        if ($modelAhorro->tipo == Ahorro::TIPO_PRIMER_PAGO) { //  si el ahorro  es tipo  primer pago y se pago en su totalidad; el socio debe pasar a aprobado  para registrarle ahorros obligatorio
                            Persona::model()->updateByPk($modelAhorro->socio->id, array(
                                'usuario_actualizacion_id' => Yii::app()->user->id,
                                'fecha_actualizacion' => Util::FechaActual(),
                                'aprobado' => 1
                                    )
                            );
                        }

                        $result['enableButtonSave'] = false; // deshabilitado en boton para hacer depositos
                    }
                    $result['success'] = $modelAhorro->save();
                }
                if (!$result['success']) { // cuando ocurre un problema al guardar en ahorro el deposito debe borrarse
                    $model->delete();
                    $result['message'] = "Error al registrar el deposito.";
                }
                echo json_encode($result);
                Yii::app()->end();
            }
            $this->renderPartial('_form_modal_deposito', array(
                'model' => $model,
                'modelAhorro' => $modelAhorro,
                    ), false, true);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDepositoAhorro() {
        if (Yii::app()->request->isAjaxRequest) {// el deposito solo se lo puede hacer mediante un modal
            $result = array();
            $fechaNext = null;
            $model = new AhorroDeposito;
            if (isset($_GET['socio_id'])) {
                $model->socio_id = $_GET['socio_id'];
            }
            $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->socio_id);

            $this->performAjaxValidation($model, 'ahorro-deposito-form');
            if (isset($_POST['AhorroDeposito'])) {
                $model->attributes = $_POST['AhorroDeposito'];
                $model->socio_id = $_POST['AhorroDeposito']['socio_id'];
                $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');
                $ahorroSocio = Ahorro::model()
                        ->findAll(
                        'socio_id=:socio_id AND estado=:estado AND tipo=:tipo ORDER BY fecha ASC', array(
                    ':socio_id' => $model->socio_id,
                    ':estado' => Ahorro::ESTADO_DEUDA,
                    ':tipo' => Ahorro::TIPO_OBLIGATORIO
                ));

                if ($model->save()) {
                    $result['success'] = true;

                    foreach ($ahorroSocio as $ahorro) {
                        if ($model->cantidad <= $ahorro->saldo_contra) {
                            $ahorro->saldo_contra = $ahorro->saldo_contra - $model->cantidad;
                            $ahorro->saldo_favor = $ahorro->saldo_favor + $model->cantidad;

                            $ahorro->estado = $ahorro->saldo_contra == 0 ? Ahorro::ESTADO_PAGADO : Ahorro::ESTADO_DEUDA;
                            if ($ahorro->save()) {
                                $modelAhorroDetalle = new AhorroDetalle;
                                $modelAhorroDetalle->ahorro_id = $ahorro->id;
                                $modelAhorroDetalle->cantidad = $model->cantidad;
                                $modelAhorroDetalle->fecha = Util::FechaActual();
                                $modelAhorroDetalle->usuario_creacion = Yii::app()->user->id;

                                $modelAhorroDetalle->save();
                                $model->cantidad = $model->cantidad - $ahorro->saldo_favor;
                            }
                        } else {
                            $initSC = $ahorro->saldo_contra;
                            $ahorro->saldo_favor = $ahorro->saldo_favor + $ahorro->saldo_contra;
                            $model->cantidad = $model->cantidad - $ahorro->saldo_contra;
                            $ahorro->saldo_contra = 0;
                            $ahorro->estado = Ahorro::ESTADO_PAGADO;
                            if ($ahorro->save()) {
                                $modelAhorroDetalle = new AhorroDetalle;
                                $modelAhorroDetalle->ahorro_id = $ahorro->id;
                                $modelAhorroDetalle->cantidad = $initSC;
                                $modelAhorroDetalle->fecha = Util::FechaActual();
                                $modelAhorroDetalle->usuario_creacion = Yii::app()->user->id;

                                $modelAhorroDetalle->save();
                            }
                        }
                        $fechaNext = Util::FormatDate(date("d/m/Y", strtotime(Util::FormatDate($ahorro->fecha, 'm/d/Y') . " +1 month")), 'Y-m-d');
                        $fecha = new DateTime($fechaNext);
                        $fecha->modify('first day of this month');
                        $fechaNext = $fecha->format('Y-m-d');

//                
                    }
                    if ($fechaNext == null) {
                        $utimaFecha = Ahorro::model()->getfechaUtimoAhorro($model->socio_id);

                        $fechaNext = Util::FormatDate(date("d/m/Y", strtotime(Util::FormatDate(($utimaFecha ? $utimaFecha : Util::FechaActual()), 'm/d/Y') . " +1 month")), 'Y-m-d');
                        $fecha = new DateTime($fechaNext);
                        $fecha->modify('first day of this month');
                        $fechaNext = $fecha->format('Y-m-d');


                        $fechaNext = Util::FormatDate(date("d/m/Y", strtotime(Util::FormatDate(Util::FechaActual(), 'm/d/Y') . " +1 month")), 'Y-m-d');
                        $fecha = new DateTime($fechaNext);
                        $fecha->modify('first day of this month');
                        $fechaNext = $fecha->format('Y-m-d');
                    }
                    while ($model->cantidad > 0) {

                        $modelAhorro = new Ahorro;
                        $modelAhorro->socio_id = $model->socio_id;
                        $modelAhorro->fecha = $fechaNext;
                        $modelAhorro->tipo = Ahorro::TIPO_OBLIGATORIO;
                        $modelAhorro->cantidad = Sucursal::model()->findByPk(Util::getSucursal())->valor_ahorro;
                        $modelAhorro->saldo_contra = $modelAhorro->cantidad;


                        if ($model->cantidad <= $modelAhorro->saldo_contra) {
                            $modelAhorro->saldo_contra = $modelAhorro->saldo_contra - $model->cantidad;
                            $modelAhorro->saldo_favor = $modelAhorro->saldo_favor + $model->cantidad;

                            $modelAhorro->estado = $modelAhorro->saldo_contra == 0 ? Ahorro::ESTADO_PAGADO : Ahorro::ESTADO_DEUDA;
                            if ($modelAhorro->save()) {

                                $modelAhorroDetalle = new AhorroDetalle;
                                $modelAhorroDetalle->ahorro_id = $modelAhorro->id;
                                $modelAhorroDetalle->cantidad = $model->cantidad;
                                $modelAhorroDetalle->fecha = Util::FechaActual();
                                $modelAhorroDetalle->usuario_creacion = Yii::app()->user->id;

                                $modelAhorroDetalle->save();
                                $model->cantidad = $model->cantidad - $modelAhorro->saldo_favor;
                            }
                        } else {
                            $initSC = $modelAhorro->saldo_contra;
                            $modelAhorro->saldo_favor = $modelAhorro->saldo_favor + $modelAhorro->saldo_contra;
                            $model->cantidad = $model->cantidad - $modelAhorro->saldo_contra;
                            $modelAhorro->saldo_contra = 0;

                            $modelAhorro->estado = Ahorro::ESTADO_PAGADO;


                            if ($modelAhorro->save()) {
                                $modelAhorroDetalle = new AhorroDetalle;
                                $modelAhorroDetalle->ahorro_id = $modelAhorro->id;
                                $modelAhorroDetalle->cantidad = $initSC;
                                $modelAhorroDetalle->fecha = Util::FechaActual();
                                $modelAhorroDetalle->usuario_creacion = Yii::app()->user->id;

                                $modelAhorroDetalle->save();
                            }
                        }
                        $fechaNext = Util::FormatDate(date("d/m/Y", strtotime(Util::FormatDate($modelAhorro->fecha, 'm/d/Y') . " +1 month")), 'Y-m-d');
                        $fecha = new DateTime($fechaNext);
                        $fecha->modify('first day of this month');
                        $fechaNext = $fecha->format('Y-m-d');
                    }
                }


                echo json_encode($result);
                Yii::app()->end();
            }

            $this->renderPartial('_form_modal_deposito_ahorro', array(
                'model' => $model,
                    ), false, true);
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad,"d-m-Y");
        $this->performAjaxValidation($model, 'ahorro-deposito-form');

        if (isset($_POST['AhorroDeposito'])) {
            $model->attributes = $_POST['AhorroDeposito'];
            $model->fecha_comprobante_entidad = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha_comprobante_entidad);
            if ($model->save()) {
                $this->redirect(array('admin', 'id' => $model->id));
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
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('AhorroDeposito');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AhorroDeposito('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['AhorroDeposito'])) {
            $model->attributes = $_GET['AhorroDeposito'];
            if ($_GET['AhorroDeposito']['sucursal_fecha_comprobante_entidad']) {
                $arrayFecha = explode('/', $_GET['AhorroDeposito']['sucursal_fecha_comprobante_entidad']);
                if (count($arrayFecha) > 1) {
                    $model->fechaMes = array(array_search($arrayFecha[0], Util::obtenerMeses()) + 1, $arrayFecha[1]);
                    $model->deMes();
                }
            }
            $model->de_socio($model->socio_id);
            $model->de_sucursal($_GET['AhorroDeposito']['sucursal_comprobante_id']);
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionConsolidado() {
        $model = new AhorroDeposito();
        $anio = Util::FormatDate(Util::FechaActual(), 'Y');
        $socio_id = null;
        $sucursal_id = Util::getSucursal();
        $model->sucursal_comprobante_id = $sucursal_id;

        if (isset($_GET['AhorroDeposito'])) {
            $anio = $_GET['AhorroDeposito']['anio'];
            $socio_id = $_GET['AhorroDeposito']['socio_id'];
            $sucursal_id = $_GET['AhorroDeposito']['sucursal_id'];
        }
        $data = $model->generateDataGridConsolidado($anio, $socio_id, $sucursal_id);

        $this->render('consolidado', array('model' => $model, 'data' => $data, 'anio' => $anio));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = AhorroDeposito::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ahorro-deposito-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarDepositos() {
        if (isset($_POST['AhorroDeposito'])) {
            $parametros = $_POST['AhorroDeposito'];
            $reporte = AhorroDeposito::model()->generateDataGridDepositos($parametros);

            //genera el reporte de excel
            $objExcel = new PHPExcel();


            //carga la consulta en la hoja 0 con el contenido de la busqueda, empezando desde la seguna fila
            $objExcel->setActiveSheetIndex(0)->fromArray($reporte, null, 'A2');
            //agrega las cabeceras 
            $objExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Nombres y Apellidos')
                    ->setCellValue('B1', 'Identificación')
                    ->setCellValue('C1', 'Cantidad')
                    ->setCellValue('D1', 'Fecha')
                    ->setCellValue('E1', 'Cod. Comprobante')
                    ->setCellValue('F1', 'Canton')
//                    ->setCellValue('G1', 'Celular')
//                    ->setCellValue('H1', 'E-mail')
//                    ->setCellValue('I1', 'Carga Familiar')
//                    ->setCellValue('J1', 'Discapacidad')
//                    ->setCellValue('K1', 'Fecha Nacimiento')
//                    ->setCellValue('L1', 'Fecha Creación')
//                    ->setCellValue('M1', 'Estado Civil')
//                    ->setCellValue('N1', 'Género')
//                    ->setCellValue('O1', 'Descripción')
            ;

            for ($i = 'A'; $i <= 'Z'; $i++) {
                $objExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
            }
//titulo de la hoja 0
            $objExcel->getActiveSheet()->setTitle('Socios');

//// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
            $objExcel->setActiveSheetIndex(0);
//// Inmovilizar paneles
            $objExcel->getActiveSheet(0)->freezePane('A2');
//                $objExcel->getActiveSheet(0)->freezePaneByColumnAndRow(1, 2);
// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//crea el archivo con el siguiente formato: Incidencias <fecha inicial> hasta <fecha final>.xlsx
            header('Content-Disposition: attachment;filename="Reporte de Socios.xlsx"');
            header('Cache-Control: max-age=0');
//genera el archivo con formato excel 2007
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');

            $objWriter->save('php://output');

//        exit();
        }
    }

    public function actionExportarConsolidado() {
        $model = new AhorroDeposito();
        $anio = Util::FormatDate(Util::FechaActual(), 'Y');
        $socio_id = null;
        $sucursal_id = Util::getSucursal();
        $model->sucursal_comprobante_id = $sucursal_id;
        if (isset($_POST['AhorroDeposito'])) {

            $anio = $_POST['AhorroDeposito']['anio'];
            $anio_anterior = $anio - 1;
            $socio_id = $_POST['AhorroDeposito']['socio_id'];
            $sucursal_id = $_POST['AhorroDeposito']['sucursal_comprobante_id'];
            $reporte = $model->generateDataGridConsolidado($anio, $socio_id, $sucursal_id);

            //genera el reporte de excel
            $objExcel = new PHPExcel();


            //carga la consulta en la hoja 0 con el contenido de la busqueda, empezando desde la seguna fila
            $objExcel->setActiveSheetIndex(0)->fromArray($reporte, null, 'A2');
            //agrega las cabeceras
            $objExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Num')
                    ->setCellValue('B1', 'Numbres')
                    ->setCellValue('C1', 'Cedula')
                    ->setCellValue('D1', 'Canton')
                    ->setCellValue('E1', "Saldo {$anio_anterior}")
                    ->setCellValue('F1', 'Ene')
                    ->setCellValue('G1', 'Feb')
                    ->setCellValue('H1', 'Mar')
                    ->setCellValue('I1', 'Abr')
                    ->setCellValue('J1', 'May')
                    ->setCellValue('K1', 'Jun')
                    ->setCellValue('L1', 'Jul')
                    ->setCellValue('M1', 'Ago')
                    ->setCellValue('N1', 'Sep')
                    ->setCellValue('O1', 'Oct')
                    ->setCellValue('P1', 'Nov')
                    ->setCellValue('Q1', 'Dic')
                    ->setCellValue('R1', "Total {$anio}");
            $id = 2;
            foreach ($reporte as $r) {
                $objExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $id, $r['id'])
                        ->setCellValue('B' . $id, $r['Nombres'])//Titulo de las columnas
                        ->setCellValue('C' . $id, $r['Cedula'])
                        ->setCellValue('D' . $id, $r['Sucursal'])
                        ->setCellValue('E' . $id, $r['Saldo'])
                        ->setCellValue('F' . $id, $r['Enero'])
                        ->setCellValue('G' . $id, $r['Febrero'])
                        ->setCellValue('H' . $id, $r['Marzo'])
                        ->setCellValue('I' . $id, $r['Abril'])
                        ->setCellValue('J' . $id, $r['Mayo'])
                        ->setCellValue('K' . $id, $r['Junio'])
                        ->setCellValue('L' . $id, $r['Julio'])
                        ->setCellValue('M' . $id, $r['Agosto'])
                        ->setCellValue('N' . $id, $r['Septiembre'])
                        ->setCellValue('O' . $id, $r['Octubre'])
                        ->setCellValue('P' . $id, $r['Noviembre'])
                        ->setCellValue('Q' . $id, $r['Diciembre'])
                        ->setCellValue('R' . $id, $r['Total'])
                ;
                $id++;
            }

            for ($i = 'A'; $i <= 'R'; $i++) {
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
