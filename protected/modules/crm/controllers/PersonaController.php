<?php

class PersonaController extends AweController {

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
        $model = new Persona;
        $modelDireccion1 = new Direccion;
        $modelDireccion2 = new Direccion;
        $model->usuario_creacion_id = Yii::app()->user->id;
        $model->fecha_creacion = Util::FechaActual();
        $model->tipo = Persona::TIPO_CLIENTE;
        $model->estado = Persona::ESTADO_ACTIVO;
        $this->performAjaxValidation(array($model));
        if (isset($_POST['Persona'])) {
            $model->attributes = $_POST['Persona'];
            $model->usuario_creacion_id = Yii::app()->user->id;
            $modelDireccion1->attributes = $_POST['Direccion1'];
            $modelDireccion2->attributes = $_POST['Direccion2'];
            $model->aprobado = 0;
            if (implode('', array_values($modelDireccion1->attributes)) != '') {
                $modelDireccion1->tipo = Direccion::TIPO_CLIENTE;
                $modelDireccion1->parroquia_id = ($modelDireccion1->parroquia_id == 0) ? null : ($modelDireccion1->parroquia_id);
                $modelDireccion1->barrio_id = ($modelDireccion1->barrio_id == 0) ? null : ($modelDireccion1->barrio_id);
                if ($modelDireccion1->save(false)) {
                    $model->direccion_domicilio_id = $modelDireccion1->id;
                }
            }
            if (implode('', array_values($modelDireccion2->attributes)) != '') {
                $modelDireccion2->tipo = Direccion::TIPO_CLIENTE;
                $modelDireccion2->parroquia_id = ($modelDireccion2->parroquia_id == 0) ? null : ($modelDireccion2->parroquia_id);
                $modelDireccion2->barrio_id = ($modelDireccion2->barrio_id == 0) ? null : ($modelDireccion2->barrio_id);
                if ($modelDireccion2->save(false)) {
                    $model->direccion_negocio_id = $modelDireccion2->id;
                }
            }
            if ($model->save()) {
                $pago = new Pago();
                $pago->descripcion = 'Pago por ingreso a la mancomunidad';
                $pago->cliente_id = $model->id;
                $pago->cantidad = Pago::VALOR_REGISTRO;
                $pago->fecha = Util::FechaActual();
                $pago->estado = Pago::ESTADO_DEUDA;
                $pago->tipo = Pago::TIPO_PRIMIER_PAGO;
                if ($pago->save()) {
                    $this->redirect(array('admin'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modelDireccion1' => $modelDireccion1,
            'modelDireccion2' => $modelDireccion2,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id, $r = null) {
        $model = $this->loadModel($id);
        $modelDireccion1 = $model->direccionDomicilio ? $model->direccionDomicilio : new Direccion;
        $modelDireccion2 = $model->direccionNegocio ? $model->direccionNegocio : new Direccion;
        $model->usuario_actualizacion_id = Yii::app()->user->id;
        $model->fecha_actualizacion = Util::FechaActual();

        $this->performAjaxValidation(array($model));
        if (isset($_POST['Persona'])) {
            $model->attributes = $_POST['Persona'];
            $model->usuario_creacion_id = Yii::app()->user->id;
            $modelDireccion1->attributes = $_POST['Direccion1'];
            $modelDireccion2->attributes = $_POST['Direccion2'];
            if (implode('', array_values($modelDireccion1->attributes)) != '') {
                $modelDireccion1->tipo = Direccion::TIPO_CLIENTE;
                if ($modelDireccion1->barrio_id == 0) {
                    $modelDireccion1->barrio_id = null;
                }
                if ($modelDireccion1->save(false)) {
                    $model->direccion_domicilio_id = $modelDireccion1->id;
                }
            }
            if (implode('', array_values($modelDireccion2->attributes)) != '') {
                $modelDireccion2->tipo = Direccion::TIPO_CLIENTE;
                if ($modelDireccion2->barrio_id == 0) {
                    $modelDireccion2->barrio_id = null;
                }
                if ($modelDireccion2->save(false)) {
                    $model->direccion_negocio_id = $modelDireccion2->id;
                }
            }
            if ($model->save()) {
                if ($r != null) {
                    $this->redirect(array('admin'));
                } else {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
        $this->render('update', array(
            'model' => $model,
            'modelDireccion1' => $modelDireccion1,
            'modelDireccion2' => $modelDireccion2,
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
            Persona::model()->updateByPk($id, array('estado' => Persona::ESTADO_INACTIVO));

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
        $model = new Persona('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['search'])) {
            $model->attributes = $this->assignParams($_GET['search']);
        }
        if (isset($_GET['Persona']))
            $model->attributes = $_GET['Persona'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Realiza en render de la vista Kanban
     * @author Armando Maldonado
     */
    public function actionKanban($id) {
        $etapas = PersonaEtapa::model()->activos()->orden()->findAll();
//        die(var_dump($incidencia_estados));
//        $result = array();
//        if (Yii::app()->request->isAjaxRequest) {
//            $result['success'] = true;
//            $result['html'] = $this->renderPartial('_kanban', array('incidencia_estados' => $incidencia_estados), TRUE, false);
//            echo json_encode($result);
//        } 
//        else
        {
            $this->render('kanban', array(
                'etapas' => $etapas,
                'id' => $id,
            ));
        }
    }

    public function actionAjaxUpdateEtapa($id_data = null, $id_etapa = null) {
        if (Yii::app()->request->isAjaxRequest) {
            Persona::model()->updateByPk($id_data, array('persona_etapa_id' => $id_etapa,
                'usuario_actualizacion_id' => Yii::app()->user->id,
                'fecha_actualizacion' => Util::FechaActual(),
                'aprobado' => 0
                    )
            );
        }
    }

    public function actionAjaxAprobado() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['cliente_id'];
            $value = (boolean) $_POST['value'];
            Persona::model()->updateByPk($id, array(
                'usuario_actualizacion_id' => Yii::app()->user->id,
                'fecha_actualizacion' => Util::FechaActual(),
                'aprobado' => $value
                    )
            );
        }
    }

    public function assignParams($params) {
        $result = array();
        if ($params['filters'][0] == 'all') {
            foreach (Persona::model()->searchParams() as $param) {
                $result[$param] = $params['value'];
            }
        } else {
            foreach ($params['filters'] as $param) {
                $result[$param] = $params['value'];
            }
        }
        return $result;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $modelClass = __CLASS__) {
        $model = Persona::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form = null) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'persona-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
