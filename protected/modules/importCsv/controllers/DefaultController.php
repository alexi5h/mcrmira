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
//            var_dump($file);
//            die();
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


                    //para la actividad Economica
                    $modelActividadEconomica = ActividadEconomica::model()->find(array(
                        'condition' => 'nombre=:nombre',
                        'params' => array(
                            ':nombre' => ucwords(utf8_encode($data[27])),
                    )));
                    //para la sucursal
                    $modelSucursal = Sucursal::model()->find(
                            array('condition' => 'nombre=:nombre_sucursal',
                                'params' => array(':nombre_sucursal' => $data[12]))
                    );

//                    var_dump($estro);
//                    die();

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
                        $modelPersona->cedula = $data[5];
//                        $modelPersona->cedula = '1002003000';//                        
                        $modelPersona->ruc = $data[6] ? $data[6] : null;
                        //TODO: comentar en datos reales
                        $modelPersona->telefono = substr($data[7], 0, 9);
                        $modelPersona->celular = substr($data[8], 0, 9);
                        //TODO: descomentar para datos reales
//                        $modelPersona->telefono = $data[7];
//                        $modelPersona->celular = $data[8];
                        $modelPersona->email = $data[9];
                        $modelPersona->descripcion = $data[10];
                        $modelPersona->tipo = strtoupper($data[11]);
                        $modelPersona->estado = Persona::ESTADO_ACTIVO;
                        $modelPersona->fecha_creacion = Util::FechaActual();
                        $modelPersona->fecha_actualizacion = NULL;
                        $modelPersona->usuario_creacion_id = Yii::app()->user->id;
                        $modelPersona->usuario_actualizacion_id = NULL;
                        $modelPersona->aprobado = 0;
                        $modelPersona->sucursal_id = count($modelSucursal) == 0 ? Util::getSucursal() : $modelSucursal->id;
                        $modelPersona->fecha_nacimiento = ($data[13] == null || $data[13] == '') ? Util::FechaActual() : Util::FormatDate($data[13], 'Y-m-d');
                        $modelPersona->sexo = ucwords(utf8_encode($data[14]));
                        $modelPersona->discapacidad = ($data[15] == null || $data[15] == '') ? Persona::DISCAPASIDAD_NO : strtoupper($data[15]);
                        $modelPersona->estado_civil = ($data[16] == null || $data[16] == '') ? Persona::ESTADO_CIVIL_SOLTERO : strtoupper($data[16]);
                        $modelPersona->carga_familiar = ($data[17] == null || $data[17] == '') ? 0 : $data[17];
                        $modelPersona->persona_etapa_id = PersonaEtapa::model()->getIdPesoMinimo();
                        $modelPersona->actividad_economica_id = $modelActividadEconomica ? $modelActividadEconomica->id : $this->crearActividadEconomica(ucwords(utf8_encode($data[26])));

                        $modelPersona->direccion_domicilio_id = $this->crearDireccion($data[18], $data[19], $data[20], $data[25], $data[24], $data[23], $data[22], $data[21]);

                        $modelPersona->direccion_negocio_id = $this->crearDireccion($data[27], $data[28], $data[29], $data[34], $data[33], $data[32], $data[31], $data[30]);


                        if (!$modelPersona->save()) {
                            var_dump($contador);
                            var_dump($modelPersona);
                            die();
                        }
                    } else {

                        /* Creacion del Socio */
//                        $modelPersona->primer_nombre = ucwords(utf8_encode($data[0]));
//                        $modelPersona->segundo_nombre = ucwords(utf8_encode($data[1]));
//                        $modelPersona->apellido_paterno = ucwords(utf8_encode($data[2]));
//                        $modelPersona->apellido_materno = ucwords(utf8_encode($data[3]));
//                        $modelPersona->tipo_identificacion = ucwords(utf8_encode($data[4]));
//                        //TODO: descomentar con pruebas reales
////                        $modelPersona->cedula = $data[5];
//                        $modelPersona->cedula = '1002003000';
////                        $modelPersona->ruc = $data[6];
//                        $modelPersona->telefono = substr($data[7], 0, 9);
//                        $modelPersona->celular = substr($data[8], 0, 9);
//                        $modelPersona->email = $data[9];
//                        $modelPersona->descripcion = $data[10];
//                        $modelPersona->tipo = $data[11];
//                        $modelPersona->estado = $data[12];
//                        $modelPersona->fecha_creacion = $data[13];
//                        $modelPersona->fecha_actualizacion = $data[14];
////                        $modelPersona->usuario_creacion_id= $data[15];                        
//                        $modelPersona->usuario_creacion_id = Yii::app()->user->id;
////                        $modelPersona->usuario_actualizacion_id = $data[16];
//                        $modelPersona->usuario_actualizacion_id = '';
//                        $modelPersona->aprobado = $data[17];
//                        //TODO: falta deinir campo en csv
//                        $modelPersona->sucursal_id = Sucursal::model()->findByPk($data[18]) ? $data[18] : '';
//                        //TODO: falta por definir en el CSV
//                        $modelPersona->persona_etapa_id = PersonaEtapa::model()->findByPk($data[19]) ? $data[19] : '';
//                        //TODO: falta por definir en el CSV
//                        $modelPersona->direccion_domicilio_id = Direccion::model()->findByPk($data[20]) ? $data[20] : '';
//                        //TODO: falta por definir en el CSV
//                        $modelPersona->direccion_negocio_id = Direccion::model()->findByPk($data[21]) ? $data[21] : '';
//                        $modelPersona->sexo = ucwords(utf8_encode($data[22]));
//                        $modelPersona->fecha_nacimiento = Util::FormatDate($data[23], 'Y-m-d');
//                        $modelPersona->carga_familiar = ($data[24] == null || $data[24] == '') ? 0 : $data[24];
//                        $modelPersona->discapacidad = strtoupper($data[25]);
//                        $modelPersona->estado_civil = strtoupper($data[26]);
//
//                        $modelPersona->actividad_economica_id = $modelActividadEconomica ? $modelActividadEconomica->id : $this->crearActividadEconomica(ucwords(utf8_encode($data[27])));
//                        if (!$modelPersona->save()) {
//                            var_dump($modelPersona);
//                            die();
//                        }
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

            if ($nombre != '' || $nombre != null) {
                return $this->crearActividadEconomica($nombre);
            } else {
                die();
                return 0;
            }
        }
    }

    //verifica direcciones si no estas las crea
    public function crearDireccion($calle1 = null, $calle2 = null, $nro = null, $referencia = null, $barrio = null, $parroquia = null, $canton = null, $provincia = null) {
//        die(var_dump($calle1, $calle2, $nro, $referencia, $barrio, $parroquia, $canton, $provincia));


        $modelProvincia = Provincia::model()->find(array("condition" => "nombre=:nombre", 'params' => array(':nombre' => utf8_encode($provincia))));
        $modelCanton = Canton::model()->find(array("condition" => "nombre=:nombre", 'params' => array(':nombre' => utf8_encode($canton))));
        $modelParroquia = Parroquia::model()->find(array("condition" => "nombre=:nombre", 'params' => array(':nombre' => utf8_encode($parroquia))));
        $modelBarrio = Barrio::model()->find(array("condition" => "nombre=:nombre", 'params' => array(':nombre' => utf8_encode($barrio))));


        //catalogos de direccion
        //direccion
        //Para Probincia
//        var_dump(count($modelProvincia) == 0, $provincia != '', $provincia != null);
        if (count($modelProvincia) == 0 && ($provincia != '' || $provincia != null)) {
            $modelProvincia = new Provincia();
            $modelProvincia->nombre = strtoupper(utf8_encode($provincia));

            $modelProvincia->save();
        }
        //Para canton
        if (count($modelCanton) == 0 && ($canton != '' || $canton != null)) {
            $modelCanton = new Canton();
            $modelCanton->nombre = strtoupper(utf8_encode($canton)); //     
            $modelCanton->provincia_id = isset($modelProvincia->id) ? $modelProvincia->id : 0;
            $modelCanton->save();
        } else if ($canton != '' || $canton != null) {
//            $modelCanton->nombre = strtoupper(utf8_encode($canton)); //     
            $modelCanton->provincia_id = isset($modelProvincia->id) ? $modelProvincia->id : 0;
            $modelCanton->save();
        }
        //Para Parroquia
        if (count($modelParroquia) == 0 && ($parroquia != '' || $parroquia != null)) {
            $modelParroquia = new Parroquia();
            $modelParroquia->nombre = strtoupper(utf8_encode($parroquia));
            $modelParroquia->canton_id = isset($modelCanton->id) ? $modelCanton->id : 0;
            $modelParroquia->save();
        } elseif ($parroquia != '' || $parroquia != null) {
//            $modelParroquia->nombre = strtoupper(utf8_encode($parroquia));
            $modelParroquia->canton_id = isset($modelCanton->id) ? $modelCanton->id : 0;
            $modelParroquia->save();
        }
        //Para barrio
        if (count($modelBarrio) == 0 && ($barrio != '' || $barrio != null)) {
            $modelBarrio = new Barrio();
            $modelBarrio->nombre = strtoupper(utf8_encode($barrio));
            $modelBarrio->parroquia_id = isset($modelParroquia->id) ? $modelParroquia->id : 0;
            $modelBarrio->save();
        } else if (($barrio != '' || $barrio != null)) {
            $modelBarrio->parroquia_id = isset($modelParroquia->id) ? $modelParroquia->id : 0;
            $modelBarrio->save();
        }


        $conditionDireccion = 'calle_1=:calle1 and calle_2=:calle2 and numero=:numero';
        $conditionParams = array(':calle1' => $calle1, ':calle2' => $calle2, ':numero' => $nro);
        if (isset($modelBarrio->id) && isset($modelParroquia->id)) {
            $conditionDireccion = $conditionDireccion . ' barrio_id=:barrio and parroquia_id=:parroquia';
            $conditionParams = array_merge($conditionParams, array(':barrio' => $modelBarrio->id, ':parroquia' => $modelParroquia->id));
        }

        $modelDireccion = Direccion::model()->find(
                array('condition' => $conditionDireccion,
                    'params' => $conditionParams
        ));
        if (count($modelDireccion) == 0) {
            $modelDireccion = new Direccion();
            $modelDireccion->calle_1 = $calle1 ? $calle1 : null;
            $modelDireccion->calle_2 = $calle2 ? $calle2 : null;
            $modelDireccion->numero = $nro;
            if ($referencia != '') {
                $modelDireccion->referencia = $referencia;
            }
            $modelDireccion->tipo = Direccion::TIPO_CLIENTE;
            if (isset($modelBarrio->id)) {
                $modelDireccion->barrio_id = $modelBarrio->id;
            }
            if (isset($modelParroquia->id)) {
                $modelDireccion->parroquia_id = $modelParroquia->id;
            }

            if ($modelDireccion->save(false)) {
                return $modelDireccion->id;
            } else {
                return $this->crearDireccion($calle1, $calle2, $nro, $referencia, $barrio_id, $parroquia_id, $canton, $provincia);
            }
        } else {
//            $modelDireccion->numero = $nro;
            if ($referencia != '') {
                $modelDireccion->referencia = $referencia;
            }
            if ($modelDireccion->save(false)) {
                return $modelDireccion->id;
            } else {
                return $this->crearDireccion($calle1, $calle2, $nro, $referencia, $barrio_id, $parroquia_id, $canton, $provincia);
            }
        }
    }

}
