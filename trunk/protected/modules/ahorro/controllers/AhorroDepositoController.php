<?php

class AhorroDepositoController extends AweController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'..
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $admin = false;

    public function filters()
    {
        return array(
            array('CrugeAccessControlFilter'),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreateDeposito()
    {
        $model = new AhorroDeposito();
        $this->performAjaxValidation($model, 'ahorro-deposito-form');

        if (isset($_POST['AhorroDeposito'])) {

            $model->attributes = $_POST['AhorroDeposito'];
            $model->cod_comprobante_su = AhorroDeposito::model()->generarCodigoComprobante($model->socio_id);
            $model->fecha_comprobante_entidad = Util::FormatDate($model->fecha_comprobante_entidad, 'Y-m-d H:i:s');
            $model->fecha_comprobante_su = Util::FormatDate(Util::FechaActual(), 'Y-m-d H:i:s');
            $model->sucursal_comprobante_id = $model->socio_id ? Persona::model()->findByPk($model->socio_id)->sucursal_id : null;
            $model->usuario_creacion_id = Yii::app()->user->id;
            if ($model->save())
                $this->redirect(array('admin'));
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id_ahorro = null)
    {
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
    public function actionCreateDepositoAhorro()
    {
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
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'ahorro-deposito-form');

        if (isset($_POST['AhorroDeposito'])) {
            $model->attributes = $_POST['AhorroDeposito'];
            $model->fecha_comprobante_entidad = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha_comprobante_entidad);
            $model->fecha_comprobante_su = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha_comprobante_su);
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
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
    public function actionDelete($id)
    {
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
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('AhorroDeposito');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new AhorroDeposito('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['AhorroDeposito'])) {
            $model->attributes = $_GET['AhorroDeposito'];

            $model->de_socio($model->socio_id);
            $model->de_sucursal($_GET['AhorroDeposito']['sucursal_comprobante_id']);
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionConsolidado()
    {
        $model = new AhorroDeposito();
        $model->generateDataGridConsolidado('2015');
        die();
        $this->render('consolidado', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__)
    {
        $model = AhorroDeposito::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ahorro-deposito-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
