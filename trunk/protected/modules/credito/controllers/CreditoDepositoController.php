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
                if ($model->cantidad+$model->interes <= $modelCredito->saldo_contra) {
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
        $model = new CreditoDeposito('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CreditoDeposito']))
            $model->attributes = $_GET['CreditoDeposito'];

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

}
