<?php

class ActividadEconomicaController extends AweController {

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
        $result = array();
        $model = new ActividadEconomica('create');
        $model->estado = ActividadEconomica::ESTADO_ACTIVO;

        $this->ajaxValidation($model, 'actividad-economica-form');

//        $validadorPartial = (isset($_GET['popoup']) && boolval($_GET['popoup'])) ? true : false;
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['ActividadEconomica'])&&isset($_GET['popoup'])) {
                $model->attributes = $_POST['ActividadEconomica'];
                $result['success'] = $model->save();

                $result['seleccion'] = $model->id;
//                $result['error'] = $model->errors;
                if ($result['success']) {
                    $result['attr'] = $model->attributes;
                }
                $validadorPartial = TRUE;
                echo json_encode($result);
            }
//            if (!$validadorPartial) {
//
//                $this->renderPartial('_form_modal', array(
//                    'model' => $model
//                        ), false, true);
//            }
        } else {
            $this->performAjaxValidation($model, 'actividad-economica-form');

            if (isset($_POST['ActividadEconomica'])) {
                $model->attributes = $_POST['ActividadEconomica'];
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
        $model->estado = ActividadEconomica::ESTADO_ACTIVO;
        $this->performAjaxValidation($model, 'actividad-economica-form');

        if (isset($_POST['ActividadEconomica'])) {
            $model->attributes = $_POST['ActividadEconomica'];
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
            $model = $this->loadModel($id);
            if (count($model->personas) == 0) {
                $model->estado = ActividadEconomica::ESTADO_INACTIVO;
                $model->save();
                echo '<div class = "alert alert-success"><button data-dismiss = "alert" class = "close" type = "button">×</button>Borrado Exitosamente.</div>';
            } else {
                echo '<div class = "alert alert-error"><button data-dismiss = "alert" class = "close" type = "button">×</button>Imposible eliminar la Actividad Económica, varias personas dependen de ésta.</div>';
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
        $model = new ActividadEconomica('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['ActividadEconomica']))
            $model->attributes = $_GET['ActividadEconomica'];

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
        $model = ActividadEconomica::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'actividad-economica-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * funcion de validacion por ajax
     * @param type $model
     * @param type $form_id
     */
    protected function ajaxValidation($model, $form_id) {
        $portAtt = str_replace('-', ' ', (str_replace('-form', '', $form_id)));
        $portAtt = ucwords(strtolower($portAtt));
        $portAtt = str_replace(' ', '', $portAtt);
        if (isset($_POST['ajax']) && $_POST['ajax'] === '#' . $form_id) {
            $model->attributes = $_POST[$portAtt];
            $result['success'] = $model->validate();
            if (!$result['success']) {
                $result['errors'] = $model->errors;
                echo json_encode($result);
                Yii::app()->end();
            }
        }
    }

    /*     * *********AJAX************ */

    public function actionAjaxGetActividadesEconomicas() {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['nuevo']) && $_POST['nuevo'] > 0) {
                $data = ActividadEconomica::model()->findAll();
//                $data = ActividadEconomica::model()->findAll(array(
//                    "condition" => "id =:id ",
//                    "params" => array(':id' => $_POST['nuevo'],)
//                ));
                //  if ($data) {
                $data = CHtml::listData($data, 'id', 'nombre');
                //echo CHtml::tag('option', array('value' => 0, 'id' => 'p'), '- Actividades -', true);
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
                //  } else {
                //    echo CHtml::tag('option', array('value' => 0), '- No existen opciones -', true);
                // }
                //  } else {
                //echo CHtml::tag('option', array('value' => 0, 'id' => 'p'), '- Seleccione un Actividad -', true);
                // }
            }
        }
    }

}
