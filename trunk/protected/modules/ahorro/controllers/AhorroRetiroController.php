<?php

class AhorroRetiroController extends AweController {

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
    public function actionCreate() {
        $model = new AhorroRetiro;
        $retiroDetalle = new AhorroRetiroDetalle();
        $validadorDetalle = false;
        $validadorSucces = true;
        $this->performAjaxValidation($model, 'ahorro-retiro-form');

        if (isset($_POST['AhorroRetiro'])) {

            $model->attributes = $_POST['AhorroRetiro'];
            $cantidadInput = floatval($model->cantidad);

            $saldoAhorro = 0;
            if ($model->tipoAhorro == Ahorro::TIPO_VOLUNTARIO) {
                $saldoAhorro = floatval(Ahorro::model()->socioAhorroVoluntarioTotal($model->socio_id));

                if ($cantidadInput <= $saldoAhorro) {
                    $listAhorrosVoluntario = Ahorro::model()->socioAhorrosVoluntarios($model->socio_id);
                    foreach ($listAhorrosVoluntario as $ahorro) {
                        $cantidadAhorro = floatval($ahorro['saldo_favor']);
//                     
                        if ($cantidadInput >= 0.00) {
                            if ($cantidadInput > $cantidadAhorro) {
                                Ahorro::model()->setAnulado($ahorro['id']);
                            } else {
                                //                            //no esta claro
                                Ahorro::model()->setAnulado($ahorro['id'], $cantidadAhorro - $cantidadInput);
                                $validadorDetalle = true;
                            }

                            $cantidadInput = $cantidadInput - $cantidadAhorro;
                        }
                    }
                } else {
                    $validadorSucces = false;
                    Yii::app()->user->setFlash('error', 'La cantidad $' . $model->cantidad . ' ingresada supera a la cantidad $' . $saldoAhorro . ' de ahorros voluntarios.');
                }
            }
            if ($validadorSucces) {
                if ($model->save()) {
                    if ($validadorDetalle) {
                        $retiroDetalle->cantidad = $cantidadAhorro;
                        $retiroDetalle->ahorro_id = $ahorro['id'];
                        $retiroDetalle->ahorro_retiro_id = $model->id;
                        $retiroDetalle->save();
                    }


                    $this->redirect(array('admin'));
                }
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

        $this->performAjaxValidation($model, 'ahorro-retiro-form');

        if (isset($_POST['AhorroRetiro'])) {
            $model->attributes = $_POST['AhorroRetiro'];
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
        $model = new AhorroRetiro('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['AhorroRetiro']))
            $model->attributes = $_GET['AhorroRetiro'];

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
        $model = AhorroRetiro::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ahorro-retiro-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
