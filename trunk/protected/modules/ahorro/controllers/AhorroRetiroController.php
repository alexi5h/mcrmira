<?php

class AhorroRetiroController extends AweController
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model Persona
     */
    public function actionAjaxInfoSOcio($id)
    {
        $socio = Persona::model()->findByPk($id);
        $this->renderPartial('_infoSocio', array('model' => $socio));
    }

    public function actionCreateRetiro($socio_id = null)
    {
        $model = new AhorroRetiro();
        $model->socio_id = $socio_id;
        $model->sucursal_id = Util::getSucursal();
        $model->usuario_creacion_id = Yii::app()->user->id;
        $this->performAjaxValidation($model, 'ahorro-retiro-form');
        if (isset($_POST['AhorroRetiro'])) {
            $model->attributes = $_POST['AhorroRetiro'];
            $model->fecha_retiro = Util::FormatDate($model->fecha_retiro, 'Y-m-d');
            if ($model->save()) {
                Persona::model()->updateByPk($model->socio_id, array('estado' => Persona::ESTADO_RETIRADO));
                $this->redirect('admin');
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new AhorroRetiro;
        $model->sucursal_id = Util::getSucursal();
        $model->fecha_retiro = Util::FormatDate(Util::FechaActual(), 'd/m/Y');
        $model->usuario_creacion_id = Yii::app()->user->id;
        $validSocio = isset($_GET['socio_id']) ? true : false;
        $saldoAhorro = 0;
        if ($validSocio) {
            $model->socio_id = $_GET['socio_id'];
            $model->cantidad = floatval(Ahorro::model()->socioAhorroTotal($_GET['socio_id']));
        }

        $validadorSucces = true;
        $this->performAjaxValidation($model, 'ahorro-retiro-form');

        if (isset($_POST['AhorroRetiro'])) {

            $model->attributes = $_POST['AhorroRetiro'];
            $cantidadInput = floatval($model->cantidad);
            $creditos = new Credito;
            $validarDataCreditos = $creditos->de_socio($model->id)->en_deuda()->count() > 0;
            if (!$validarDataCreditos) {
                $saldoAhorro = floatval(Ahorro::model()->socioAhorroTotal($model->socio_id));//Todo Cambia a ahorroDeposito

                if ($cantidadInput <= $saldoAhorro) {
                    $model->fecha_retiro = Util::FormatDate($model->fecha_retiro, 'Y-m-d');

                    if ($model->save()) {
//                        $modelPersona = $model->socio;
                        Persona::model()->updateByPk($model->socio_id, array('estado' => Persona::ESTADO_RETIRADO));
                    }
                    $validadorSucces = true;
                } else {
                    $validadorSucces = false;
                    Yii::app()->user->setFlash('error', 'La cantidad $' . $model->cantidad . ' ingresada supera a la cantidad de lo ahorros igual a $' . $saldoAhorro . '');
                }
            } else {
                $validadorSucces = false;
                Yii::app()->user->setFlash('error', 'Este socio tiene todavía Creditos por pagar');
            }

            if ($validadorSucces) {
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
    public function actionUpdate($id)
    {
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
     * Manages all models.
     */
    public function actionAdmin()
    {
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
    public function loadModel($id, $modelClass = __CLASS__)
    {
        $model = AhorroRetiro::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ahorro-retiro-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
