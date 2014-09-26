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
            $model->fecha_credito = Util::FechaActual();
            $model->estado = Credito::ESTADO_DEUDA;
            $model->interes = Credito::INTERES;

            $fecha_lim = new DateTime(Util::FechaActual());
            $fecha_lim->add(new DateInterval('P' . $model->periodos . 'M'));
            $model->fecha_limite = $fecha_lim->format('Y-m-d H:i:s');

            $info_Amortizacion = Util::calculo_amortizacion($model->cantidad_total, $model->interes, $model->periodos);
            $model->total_pagar = $info_Amortizacion['suma_cuota'];
            $model->total_interes = $info_Amortizacion['suma_interes'];
            $model->saldo_contra=$model->total_pagar;
            $model->saldo_favor=0;
            $model->anulado=  Credito::NO_ANULADO;

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
                    $modelAmort->saldo_contra=$modelAmort->cuota;
                    $modelAmort->saldo_favor=0;
                    $modelAmort->credito_id = $model->id;
                    $modelAmort->save();
                }
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
        if (isset($_GET['Credito']))
            $model->attributes = $_GET['Credito'];

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

}
