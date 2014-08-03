<?php

class SucursalController extends AweController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';
    public $admin = true;

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

        $model = new Sucursal;
        $modelDireccion = new Direccion('register');
        $modelDireccion->tipo = Direccion::TIPO_SUCURSAL;
        $model->estado = Sucursal::ESTADO_ACTIVO;
        $this->performAjaxValidation(array($model, $modelDireccion));
        if (isset($_POST['Sucursal'])) {
            $model->attributes = $_POST['Sucursal'];
            $modelDireccion->attributes = $_POST['Direccion'];
            if ($modelDireccion->barrio_id == 0)
                $modelDireccion->barrio_id = null;

            if ($modelDireccion->save()) {
                $model->direccion_id = $modelDireccion->id;
                if ($model->save()) {
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modelDireccion' => $modelDireccion,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modelDireccion = $model->direccion;
        $this->performAjaxValidation(array($model, $modelDireccion));
        if (isset($_POST['Sucursal'])) {
            $model->attributes = $_POST['Sucursal'];
            $modelDireccion->attributes = $_POST['Direccion'];
            if ($modelDireccion->barrio_id == 0)
                $modelDireccion->barrio_id = null;

            if ($modelDireccion->save()) {
                $model->direccion_id = $modelDireccion->id;
                if ($model->save()) {
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'modelDireccion' => $modelDireccion,
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
//            $this->loadModel($id)->delete();

            $model = $this->loadModel($id);
            $personas = $model->personas;
            if (count($personas) == 0) {
                echo '<div class = "alert alert-success"><button data-dismiss = "alert" class = "close" type = "button">×</button>Borrado Exitosamente.</div>';
                $model->estado = Sucursal::ESTADO_INACTIVO;
                $model->save();
            } else if (count($personas) >= 1) {
                echo '<div class = "alert alert-error"><button data-dismiss = "alert" class = "close" type = "button">×</button>Imposible eliminar la Sucursal, varias personas dependen de éste.</div>';
            }

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
        $model = new Sucursal('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Sucursal']))
            $model->attributes = $_GET['Sucursal'];

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
        $model = Sucursal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sucursal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
