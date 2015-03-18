<?php

Yii::import('ahorro.models.*');

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
        $model = $this->loadModel($id);
        $modelDepositoAhorro = new AhorroDeposito;
        $modelDepositoCredito = new CreditoDeposito;
        $depositosAhorro = $modelDepositoAhorro->searchDepositosSocio($model->id);
        $depositosCredito = $modelDepositoCredito->searchDepositosSocio($model->id);
        $gridDataProvider = new CArrayDataProvider(array_merge($depositosCredito->getData(), $depositosAhorro->getData()));
        $this->render('view', array(
            'model' => $model,
            'gridDataProvider' => $gridDataProvider
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
//        $idEtapa = PersonaEtapa::model()->getIdPesoMinimo();
//        $model->persona_etapa_id = $idEtapa;
        $model->usuario_creacion_id = Yii::app()->user->id;


        $model->tipo = Persona::TIPO_NUEVO;
        $model->estado = Persona::ESTADO_ACTIVO;
        $model->discapacidad = 'NO';

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

            $model->fecha_creacion = Util::FormatDate($_POST['Persona']['fecha_creacion'], 'Y-m-d');
            $model->fecha_nacimiento = Util::FormatDate($model->fecha_nacimiento, 'Y-m-d');

            if ($model->save()) {
                $this->redirect(array('admin'));
            }
            $model->fecha_creacion = Util::FormatDate($_POST['Persona']['fecha_creacion'], 'Y-m-d');
            $model->fecha_nacimiento = Util::FormatDate($model->fecha_nacimiento, 'd/m/Y');
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
            $model->fecha_nacimiento = Util::FormatDate($model->fecha_nacimiento, 'Y-m-d');
            if ($model->save()) {
                if ($r != null) {
                    $this->redirect(array('admin'));
                } else {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }
        $model->fecha_nacimiento = Util::FormatDate($model->fecha_nacimiento, 'd/m/Y');
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

        if (isset($_GET['Persona'])) {
            $model->attributes = $_GET['Persona'];
            $model->de_ids($model->id);
            $model->de_sucursal($_GET['Persona']['sucursal_ids']);
            $_GET['Persona']['madreSoltera'] == 'true' ? $model->madreSoltera() : '';
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionExportarSocio() {
        if (isset($_POST['Persona'])) {
            $parametros = $_POST['Persona'];
            $reporte = Persona::model()->generateExcel($parametros);

            //genera el reporte de excel
            $objExcel = new PHPExcel();


            //carga la consulta en la hoja 0 con el contenido de la busqueda, empezando desde la seguna fila
            $objExcel->setActiveSheetIndex(0)->fromArray($reporte, null, 'A2');
            //agrega las cabeceras 
            $objExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Nombres y Apellidos')
                    ->setCellValue('B1', 'Identificación')
                    ->setCellValue('C1', ' Ruc')
                    ->setCellValue('D1', 'Actividad Económica')
                    ->setCellValue('E1', 'Tipo')
                    ->setCellValue('F1', 'Teléfono')
                    ->setCellValue('G1', 'Celular')
                    ->setCellValue('H1', 'E-mail')
                    ->setCellValue('I1', 'Carga Familiar')
                    ->setCellValue('J1', 'Discapacidad')
                    ->setCellValue('K1', 'Fecha Nacimiento')
                    ->setCellValue('L1', 'Fecha Creación')
                    ->setCellValue('M1', 'Estado Civil')
                    ->setCellValue('N1', 'Género')
                    ->setCellValue('O1', 'Descripción')
            ;

            for ($i = 'A'; $i <= 'Z'; $i++) {
                $objExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
            }
//titulo de la hoja 0
            $objExcel->getActiveSheet()->setTitle('Socios');

//// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
            $objExcel->setActiveSheetIndex(0);
//// Inmovilizar paneles
            $objExcel->getActiveSheet(0)->freezePane('A2');
//                $objExcel->getActiveSheet(0)->freezePaneByColumnAndRow(1, 2);
// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//crea el archivo con el siguiente formato: Incidencias <fecha inicial> hasta <fecha final>.xlsx
            header('Content-Disposition: attachment;filename="Reporte de Socios.xlsx"');
            header('Cache-Control: max-age=0');
//genera el archivo con formato excel 2007
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');

            $objWriter->save('php://output');

//        exit();
        }
    }

    public function actionEtapa_aprobado() {
        $model = new Persona('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['search'])) {
            $model->attributes = $this->assignParams($_GET['search']);
        }
        if (isset($_GET['Persona']))
            $model->attributes = $_GET['Persona'];

        $c_activos = Yii::app()->db->createCommand()
                ->select('*')
                ->from('persona p')
                ->join('persona_etapa e', 'p.persona_etapa_id=e.id')
                ->where(array('and', 'e.id=3', 'p.aprobado=0'))
                ->queryAll();
//return $c_activos;
        $c_activos_data = new CArrayDataProvider($c_activos, array(
            'keyField' => 'id',
            'sort' => array(
                'attributes' => $model->attributeLabels(),
                'defaultOrder' => array(
                    'id' => CSort::SORT_ASC, //default sort value
                ),
            ),
            'pagination' => array('pageSize' => 30,)
        ));
        $this->render('etapa_aprobado', array(
            'model' => $model,
            'c_activos_data' => $c_activos_data,
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
            $id_etapa_max = PersonaEtapa::model()->getEtapaMaxima();
            if ($id_etapa_max == $id_etapa) {
                $ahorro = new Ahorro;
                $ahorro->descripcion = 'Primer pago por registro en la Mancomunidad';
                $ahorro->socio_id = $id_data;
                $ahorro->cantidad = Ahorro::VALOR_REGISTRO;
                $ahorro->fecha = Util::FechaActual();
                $ahorro->estado = Ahorro::ESTADO_DEUDA;
                $ahorro->tipo = Ahorro::TIPO_PRIMER_PAGO;
                $ahorro->saldo_contra = Ahorro::VALOR_REGISTRO;
                $ahorro->saldo_favor = 0;
                $ahorro->anulado = Ahorro::ANULADO_NO;
                $ahorro->save();
            }
            Persona::model()->updateByPk($id_data, array(
                'persona_etapa_id' => $id_etapa,
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
            $value = $_POST['value'];
            Persona::model()->updateByPk($id, array(
                'usuario_actualizacion_id' => Yii::app()->user->id,
                'fecha_actualizacion' => Util::FechaActual(),
                'aprobado' => $value == 'false' ? 0 : 1
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

    public function actionAjaxGetGarantes() {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['socio_id']) && $_POST['socio_id'] > 0) {
                $data = Persona::model()->condicion_garante_credito($_POST['socio_id']);
                if ($data) {
                    $data = CHtml::listData($data, 'id', 'cedula_nombre_formato');
                    echo CHtml::tag('option', array('value' => '', 'id' => 'p', 'selected' => 'selected'), '- Seleccione -', true);
                    foreach ($data as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                } else {
                    echo CHtml::tag('option', array('value' => 0), '- No existen opciones -', true);
                }
            } else {
                echo CHtml::tag('option', array('value' => 0, 'id' => 'p'), '- Seleccione un socio -', true);
            }
        }
    }

    public function actionAjaxlistSocios($search_value = null, $credito_socio = false, $credito_garante_socio_id = null) {
        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(Persona::model()->getListSelect2($search_value, $credito_socio, $credito_garante_socio_id));
        }
    }

}
