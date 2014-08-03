<?php

class PagoMesController extends AweController {

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
        $model = new PagoMes;

        $this->performAjaxValidation($model, 'pago-mes-form');

        if (isset($_POST['PagoMes'])) {
            $model->attributes = $_POST['PagoMes'];
            $model->fecha = Yii::app()->dateFormatter->format("yyyy-MM-dd hh:mm:ss", $model->fecha);
            $model->estado = PagoMes::ESTADO_DEUDA;
            
            $model_persona = new Persona();
            $model_persona->unsetAttributes();
            $model_persona=  Persona::model()->findByAttributes(array('id'=>$model->cliente_id));
            $model->cantidad=$model_persona->id;
//            $model_persona->id = $model->cliente_id;
//            if (isset($_GET['Persona'])) {
//                $model_persona->attributes = $_GET['Persona'];
//            }
//            
//            if($model_persona->estado=='ACTIVO'){
//                
//            }
            if ($model->save()) {
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

        $this->performAjaxValidation($model, 'pago-mes-form');

        if (isset($_POST['PagoMes'])) {
            $model->attributes = $_POST['PagoMes'];

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
        $model = new PagoMes('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['PagoMes']))
            $model->attributes = $_GET['PagoMes'];

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
        $model = PagoMes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pago-mes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
