<?php

class AhorroController extends AweController {

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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($ahorro_id = null, $cantidad_extra = null) {
        $model = new Ahorro('create');

        if (Yii::app()->request->isAjaxRequest) {
            $this->performAjaxValidation($model, 'ahorro-form-modal');
            $model->id = $ahorro_id;
            $model->cantidad = $cantidad_extra;
            $model->tipo == Ahorro::TIPO_VOLUNTARIO;
            $validadorPartial = true;
            if (isset($_POST['Ahorro'])) {
                $modelAhorro = Ahorro::model()->findByPk($ahorro_id);
                $model->attributes = $_POST['Ahorro'];
                $model->fecha = Util::FormatDate($model->fecha, 'Y-m-d');
                if ($model->tipo == Ahorro::TIPO_VOLUNTARIO) {
                    $model->descripcion = Ahorro::DESCRIPCION_CANTIDAD_EXTRA;
                    $model->socio_id = $modelAhorro->socio_id;
                    $model->fecha = Util::FechaActual();
                    $model->estado = Ahorro::ESTADO_PAGADO;
                    $model->saldo_contra = 0;
                    $model->saldo_favor = $model->cantidad;
                    $model->anulado = Ahorro::ANULADO_NO;
                    if ($model->save()) {
                        $result['success'] = true;
                        $result['message'] = "Cantidad ingresada correctamente";
                    }
                    if (!$result['success']) {
                        $model->delete();
                        $result['message'] = "Error al registrar el nuevo ahorro.";
                    }
                    $validadorPartial = false;
                    echo json_encode($result);
                }
            }
            if ($validadorPartial) {
                    $this->renderPartial('_decision_modal', array(
                        'model' => $model,
                            ), false, true);
                }
        } else {
            $this->performAjaxValidation($model, 'ahorro-form');
            if (isset($_POST['Ahorro'])) {
                $model->attributes = $_POST['Ahorro'];
                $model->fecha = Util::FormatDate($model->fecha, 'Y-m-d');
                if ($model->tipo == Ahorro::TIPO_OBLIGATORIO || $model->tipo == Ahorro::TIPO_PRIMER_PAGO) {
                    $model->estado = Ahorro::ESTADO_DEUDA;
                    $model->saldo_contra = $model->cantidad;
                    $model->anulado = Ahorro::ANULADO_NO;
                } else {
                    $model->estado = null;
                }
                if ($model->save()) {
                    $this->redirect(array('admin'));
                }
            }
            $this->render('create', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model, 'ahorro-form');

        if (isset($_POST['Ahorro'])) {
            $model->attributes = $_POST['Ahorro'];
//            $model->fecha = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha);
            $model->fecha = Util::FormatDate($model->fecha, 'Y-m-d');
            if ($model->save()) {
                $this->redirect(array('admin'));
            }
        }
        $model->fecha = Util::FormatDate($model->fecha, 'd/m/Y');
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
        $model = new Ahorro('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Ahorro']))
            $model->attributes = $_GET['Ahorro'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxCreateAhorroVoluntario($socio_id) {
        if (Yii::app()->request->isAjaxRequest) {
            $render_form = true;
            $result = array();
            $model = new Ahorro;
            $modelDeposito = new AhorroDeposito;

            $model->tipo = Ahorro::TIPO_VOLUNTARIO;
            $model->socio_id = $socio_id;
            $model->estado = Ahorro::ESTADO_PAGADO;
            $model->fecha = Util::FechaActual();
            if (isset($_POST['ajax']) && $_POST['ajax'] === '#ahorro-deposito-form') {
                $modelDeposito->attributes = $_POST['AhorroDeposito'];
                $modelDeposito->ahorro_id = 0;
                $result['success'] = $modelDeposito->validate();
                $result['errors'] = $modelDeposito->errors;
                if (!$result['success']) {
                    echo CJSON::encode($result);
                    Yii::app()->end();
                }
            }
            if (isset($_POST['AhorroDeposito'])) {
                $render_form = false;
                $modelDeposito->attributes = $_POST['AhorroDeposito'];
                $modelDeposito->fecha_comprobante_su = Util::FormatDate($modelDeposito->fecha_comprobante_su, 'Y-m-d H:i:s');
                $modelDeposito->fecha_comprobante_entidad = Util::FormatDate($modelDeposito->fecha_comprobante_entidad, 'Y-m-d H:i:s');

                $model->saldo_contra = 0;
                $model->saldo_favor = $_POST['AhorroDeposito']['cantidad'];
                $model->cantidad = $_POST['AhorroDeposito']['cantidad'];
                $model->descripcion = $_POST['AhorroDeposito']['observaciones'];
                $model->anulado = Ahorro::ANULADO_NO;
                $result['success'] = $model->save();
                if ($result['success']) {
                    $modelDeposito->ahorro_id = $model->id;
                    $result['success'] = $result['success'] && $modelDeposito->save();
                } else {
                    $result['message'] = 'Error al registrar el ahorro, porfavor intente nuevamente';
                }
                echo CJSON::encode($result);
            }

            if ($render_form) {
                $this->renderPartial('_form_modal', array('model' => $modelDeposito), false, true);
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = Ahorro::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ahorro-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
