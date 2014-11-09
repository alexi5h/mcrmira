<?php

Yii::import('crm.models.*');

class DefaultController extends Controller {

    /**
     * @var bool context of the menu type. 
     */
    public $admin = true;

    public function actionIndex() {
        $model = new ImportForm;

        if (isset($_POST['ImportForm'])) {

            $model->attributes = $_POST['ImportForm'];
            $model->csv_file = CUploadedFile::getInstance($model, 'csv_file');
            $entidad_tipo = $_POST['ImportForm']['tipo_entidad'];

            if ($model->validate()) {
// Subir el archivo
                $name = 'import_' . date('U') . rand(0, date('U')) . '.csv';
                $path = Yii::app()->controller->module->path;
                $model->csv_file->saveAs($path . $name);

// Cargar el archivo
                if ($file = fopen($path . $name, 'r')) {

//                    $data = fgetcsv($file, 1000, ",");
                    $data = fgetcsv($file, 1000, ";");
                    if ($entidad_tipo == ImportForm::TIPO_ENTIDAD_SOCIO) {

                        if (in_array("cedula", $data)) {
                            $this->cargaCsvSocio($file);
                        } else {
                            Yii::app()->user->setFlash('error', "Archivo no corresponde a Socios.Por favor reviselo y vuelva a intentar.");
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('error', "Error al abrir el archivo.");
                }
            }
        }


        $this->render('index', array(
            'model' => $model
        ));
    }

    public function cargaCsvSocio($file) {
        $contador = 0;



// Empezar una transaccion
        $transaction = Yii::app()->db->beginTransaction();

        try {
//            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) { // Me barro por cada fila
            while (($data = fgetcsv($file, 1000, ";")) !== FALSE) { // Me barro por cada fila
//TODO: Guardar la informacion
                {


                    $modelPersona = Persona::model()->find(
                            //TODO: Habilitar con datos reales
//                            array("condition" => "primer_nombre=:nombre and apellido_paterno=:apellido or cedula=:cedula",
                            array("condition" => "primer_nombre=:nombre and apellido_paterno=:apellido",
                                'params' => array(
                                    ':nombre' => ucwords(utf8_encode($data[0])),
                                    ':apellido' => ucwords(utf8_encode($data[2])),
//                                    ':cedula' => $data[5],
                                ))
                    );

//                    var_dump(count($modelPersona));
//                    die();
                    //para la actividad Economica
                    $modelActividadEconomica = ActividadEconomica::model()->find(array(
                        'condition' => 'nombre=:nombre',
                        'params' => array(
                            ':nombre' => ucwords(utf8_encode($data[27])),
                    )));

                    if (count($modelPersona) == 0) {
//                        die(var_dump($data[4]));
                        /* Creacion del Socio */
                        $modelPersona = new Persona();
                        $modelPersona->primer_nombre = ucwords(utf8_encode($data[0]));
                        $modelPersona->segundo_nombre = ucwords(utf8_encode($data[1]));
                        $modelPersona->apellido_paterno = ucwords(utf8_encode($data[2]));
                        $modelPersona->apellido_materno = ucwords(utf8_encode($data[3]));
                        $modelPersona->tipo_identificacion = ucwords(utf8_encode($data[4]));
                        //TODO: descomentar con pruebas reales
//                        $modelPersona->cedula = $data[5];
                        $modelPersona->cedula = '1002003000';
//                        $modelPersona->ruc = $data[6];
                        $modelPersona->telefono = substr($data[7], 0, 9);
                        $modelPersona->celular = substr($data[8], 0, 9);
                        $modelPersona->email = $data[9];
                        $modelPersona->descripcion = $data[10];
                        $modelPersona->tipo = $data[11];
                        $modelPersona->estado = $data[12];
                        $modelPersona->fecha_creacion = $data[13];
                        $modelPersona->fecha_actualizacion = $data[14];
//                        $modelPersona->usuario_creacion_id= $data[15];                        
                        $modelPersona->usuario_creacion_id = Yii::app()->user->id;
//                        $modelPersona->usuario_actualizacion_id = $data[16];
                        $modelPersona->usuario_actualizacion_id = '';
                        $modelPersona->aprobado = $data[17];
                        //TODO: falta deinir campo en csv                        
                        $modelPersona->sucursal_id = Sucursal::model()->findByPk($data[18]) ? $data[18] : '';
                        //TODO: falta por definir en el CSV
                        $modelPersona->persona_etapa_id = PersonaEtapa::model()->findByPk($data[19]) ? $data[19] : '';
                        //TODO: falta por definir en el CSV
                        $modelPersona->direccion_domicilio_id = Direccion::model()->findByPk($data[20]) ? $data[20] : '';
                        //TODO: falta por definir en el CSV
                        $modelPersona->direccion_negocio_id = Direccion::model()->findByPk($data[21]) ? $data[21] : '';
                        $modelPersona->sexo = ucwords(utf8_encode($data[22]));
                        $modelPersona->fecha_nacimiento = Util::FormatDate($data[23], 'Y-m-d');
                        $modelPersona->carga_familiar = ($data[24] == null || $data[24] == '') ? 0 : $data[24];
                        $modelPersona->discapacidad = strtoupper($data[25]);
                        $modelPersona->estado_civil = strtoupper($data[26]);

                        $modelPersona->actividad_economica_id = $modelActividadEconomica ? $modelActividadEconomica->id : $this->crearActividadEconomica(ucwords(utf8_encode($data[27])));

                        if (!$modelPersona->save()) {
                            var_dump($modelPersona);
                            die();
                        }
                    } else {
                        /* Creacion del Socio */
                        $modelPersona->primer_nombre = ucwords(utf8_encode($data[0]));
                        $modelPersona->segundo_nombre = ucwords(utf8_encode($data[1]));
                        $modelPersona->apellido_paterno = ucwords(utf8_encode($data[2]));
                        $modelPersona->apellido_materno = ucwords(utf8_encode($data[3]));
                        $modelPersona->tipo_identificacion = ucwords(utf8_encode($data[4]));
                        //TODO: descomentar con pruebas reales
//                        $modelPersona->cedula = $data[5];
                        $modelPersona->cedula = '1002003000';
//                        $modelPersona->ruc = $data[6];
                        $modelPersona->telefono = substr($data[7], 0, 9);
                        $modelPersona->celular = substr($data[8], 0, 9);
                        $modelPersona->email = $data[9];
                        $modelPersona->descripcion = $data[10];
                        $modelPersona->tipo = $data[11];
                        $modelPersona->estado = $data[12];
                        $modelPersona->fecha_creacion = $data[13];
                        $modelPersona->fecha_actualizacion = $data[14];
//                        $modelPersona->usuario_creacion_id= $data[15];                        
                        $modelPersona->usuario_creacion_id = Yii::app()->user->id;
//                        $modelPersona->usuario_actualizacion_id = $data[16];
                        $modelPersona->usuario_actualizacion_id = '';
                        $modelPersona->aprobado = $data[17];
                        //TODO: falta deinir campo en csv
                        $modelPersona->sucursal_id = Sucursal::model()->findByPk($data[18]) ? $data[18] : '';
                        //TODO: falta por definir en el CSV
                        $modelPersona->persona_etapa_id = PersonaEtapa::model()->findByPk($data[19]) ? $data[19] : '';
                        //TODO: falta por definir en el CSV
                        $modelPersona->direccion_domicilio_id = Direccion::model()->findByPk($data[20]) ? $data[20] : '';
                        //TODO: falta por definir en el CSV
                        $modelPersona->direccion_negocio_id = Direccion::model()->findByPk($data[21]) ? $data[21] : '';
                        $modelPersona->sexo = ucwords(utf8_encode($data[22]));
                        $modelPersona->fecha_nacimiento = Util::FormatDate($data[23], 'Y-m-d');
                        $modelPersona->carga_familiar = ($data[24] == null || $data[24] == '') ? 0 : $data[24];
                        $modelPersona->discapacidad = strtoupper($data[25]);
                        $modelPersona->estado_civil = strtoupper($data[26]);

                        $modelPersona->actividad_economica_id = $modelActividadEconomica ? $modelActividadEconomica->id : $this->crearActividadEconomica(ucwords(utf8_encode($data[27])));
                        if (!$modelPersona->save()) {
                            var_dump($modelPersona);
                            die();
                        }
                    }
                }
                $contador++;
            }
            Yii::app()->user->setFlash('success', "Archivo importado correctamente.");
// Hago commit de la transaccion
            $transaction->commit();
        } catch (Exception $ex) {
// Si hay error hago rollback de la transaccion y no guardo nada
            echo $ex;
            var_dump($modelPersona);
            die();
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "El archivo tiene datos erroneos. Por favor corrijalos vuelva a intentar.");
        }
    }

    public function validadorUbicacion($modelArray, $modelActual, $tipo = null) {
        foreach ($modelArray as $value) {
            if ($tipo == 'PROVINCIA') {
                if ($value->region_id == $modelActual->id) {
                    return true;
                }
            } elseif ($tipo == 'CANTON') {
                if ($value->provincia_id == $modelActual->id) {
                    return true;
                }
            } elseif ($tipo == 'CIUDAD') {
//                die(var_dump($value,'modelactu',$modelActual));
                if ($value->canton_id == $modelActual->id) {
                    return true;
                }
            }
        }
        return false;
    }

    //para crear una actividad economica si no existe
    public function crearActividadEconomica($nombre) {
        $modelActividad = new ActividadEconomica;
        $modelActividad->nombre = $nombre;
        $modelActividad->estado = ActividadEconomica::ESTADO_ACTIVO;
        if ($modelActividad->save()) {
//            var_dump($modelActividad);
//            var_dump($modelActividad->save());
//            var_dump($modelActividad->getErrors());
//            var_dump($modelActividad);
            return $modelActividad->id;
        } else {
            return $this->crearActividadEconomica($nombre);
        }
    }

}
