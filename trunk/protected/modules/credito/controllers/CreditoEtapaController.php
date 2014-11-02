<?php

class CreditoEtapaController extends AweController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $admin = true;
    public $defaultAction = 'admin';

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
        $model = new CreditoEtapa;
        $model->estado = CreditoEtapa::ESTADO_ACTIVO;
        $this->performAjaxValidation($model, 'credito-etapa-form');

        if (isset($_POST['CreditoEtapa'])) {
            $model->attributes = $_POST['CreditoEtapa'];
            $model->peso = CreditoEtapa::model()->getPesoMaximo() + 1;
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

        $this->performAjaxValidation($model, 'credito-etapa-form');

        if (isset($_POST['CreditoEtapa'])) {
            $model->attributes = $_POST['CreditoEtapa'];
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
            $etapa = $this->loadModel($id);
            if (count($etapa->creditos) == 0) {
                $etapa->estado = CreditoEtapa::ESTADO_INACTIVO;
                $etapa->save();
                echo '<div class = "alert alert-success"><button data-dismiss = "alert" class = "close" type = "button">×</button>Estado borrado satisfactoriamente.</div>';
            } else if (count($etapa->creditos) > 0) {
                echo '<div class = "alert alert-error"><button data-dismiss = "alert" class = "close" type = "button">×</button>No puede borrar este estado por que hay varias incidencias que dependen de él. </div>';
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
        $model = new CreditoEtapa('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CreditoEtapa']))
            $model->attributes = $_GET['CreditoEtapa'];

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
        $model = CreditoEtapa::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'credito-etapa-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
        /**
     * Reordena cada ves que una IncidenciaEstado fue cambiado de posicion en sortable del admin
     * @autor Armando Maldonado
     */
    public function actionReordenar() {

        $model = new CreditoEtapa('search');
        if (isset($_POST)) {
            $id_sortable = $_POST['dragged_item_id']; // valor del item que se esta arrastrando
            $id_reemplazo = $_POST['replacement_item_id']; // valor del contenedor destino o en item al cual se le esta reemplazando
            $peso_sortable = CreditoEtapa::model()->findByPk($id_sortable)->peso;
            $peso_reemplazo = CreditoEtapa::model()->findByPk($id_reemplazo)->peso;

            $this->sortable($id_sortable, $peso_sortable, $id_reemplazo, $peso_reemplazo);
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Calcula y cambia de peso cada ves que en item se actualiza mediante widgetsortable view admin
     * @param type $id_sortable
     * @param type $peso_sortable
     * @param type $id_reemplazo
     * @param type $peso_reemplazo
     */
    public function sortable($id_sortable, $peso_sortable, $id_reemplazo, $peso_reemplazo) {
        $modelEtap = CreditoEtapa::model()->getCreditoEtapa();
        $bandera = FALSE;
        if ($peso_sortable > $peso_reemplazo) {
            foreach ($modelEtap as $etap) {
                if ($etap['id'] == $id_reemplazo || $bandera) {
                    $etap['peso'] = $etap['peso'] + 1;
                    CreditoEtapa::model()->updateByPk($etap['id'], array('peso' => $etap['peso']));
                    if ($etap['id'] == $id_sortable) {
                        CreditoEtapa::model()->updateByPk($etap['id'], array('peso' => $peso_reemplazo));
                        $bandera = false;
                    } else {
                        $bandera = TRUE;
                    }
                }
            }
        } else if ($peso_sortable < $peso_reemplazo) {
            $bandera2 = false;
            foreach ($modelEtap as $etap) {
                if ($etap['id'] == $id_sortable) {
                    CreditoEtapa::model()->updateByPk($etap['id'], array('peso' => $peso_reemplazo));
                    $bandera2 = TRUE;
                } else if ($bandera2) {
                    if ($etap['id'] == $id_reemplazo) {
                        $etap['peso'] = $etap['peso'] - 1;
                        CreditoEtapa::model()->updateByPk($etap['id'], array('peso' => $etap['peso']));
                        $bandera2 = FALSE;
                    } else {
                        $etap['peso'] = $etap['peso'] - 1;
                        CreditoEtapa::model()->updateByPk($etap['id'], array('peso' => $etap['peso']));
                    }
                }
            }
        }
    }

    /**
     * Reordena los pesos despues que una IncidenciaEstado se elimina 
     * @author Armando Maldonado
     */
    public function ReordenarPesoDeleted() {
        $modelEtap = CreditoEtapa::model()->getCreditoEtapa();
        $peso = 1;
        foreach ($modelEtap as $etap) {
            CreditoEtapa::model()->updateByPk($etap['id'], array('peso' => $peso));
            $peso++;
        }
    }

}
