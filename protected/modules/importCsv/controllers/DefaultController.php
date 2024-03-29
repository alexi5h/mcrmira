<?php

Yii::import('crm.models.*');

class DefaultController extends Controller
{

    /**
     * @var bool context of the menu type.
     */
    public $admin = true;

    public function actionIndex()
    {
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

                    $data = fgetcsv($file, 1000, ";");
                    if ($entidad_tipo == ImportForm::TIPO_ENTIDAD_SOCIO) {// a que tabla

                        if (in_array("CEDULA", $data)) {// para saber si ay una cedula
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

    public function cargaCsvSocio($file)
    {
        $contador = 0;


// Empezar una transaccion
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $errors=array();
//            while (($data = fgetcsv($file, 1000, ",")) !== FALSE) { // Me barro por cada fila
            while (($data = fgetcsv($file, 1000, ";")) !== FALSE) { // Me barro por cada fila
//TODO: Guardar la informacion
                {

                    //formateo la cedula
                    $cedula=trim($data[4]);
                    $cedula=str_replace('-','',$cedula);
                    $cedula=str_replace(' ','',$cedula);
                    $cedula=sprintf("%010s",    $cedula); //456789122====>0456789122


                    $modelPersona = Persona::model()->find(
                        array("condition" => "cedula=:cedula",
                            'params' => array(
                                ':cedula' =>$cedula,
                            ))
                    );
//
////para la sucursal
                    $modelSucursal = Sucursal::model()->find(
                        array('condition' => 'nombre=:nombre_sucursal',
                            'params' => array(':nombre_sucursal' => $data[5]))
                    );

                    if (count($modelPersona) == 0) {
                        /* Creacion de nuevo Socio */
                        $modelPersona = new Persona();
                        $modelPersona->scenario='import';
                        $modelPersona->primer_nombre = ucwords(utf8_encode($data[2]));
                        $modelPersona->segundo_nombre = ucwords(utf8_encode($data[3]));
                        $modelPersona->apellido_paterno = ucwords(utf8_encode($data[0]));
                        $modelPersona->apellido_materno = ucwords(utf8_encode($data[1]));
                        $modelPersona->cedula = $cedula;
                        $modelPersona->estado = Persona::ESTADO_ACTIVO;
                        $modelPersona->fecha_creacion = Util::FechaActual();
                        $modelPersona->fecha_actualizacion = NULL;
                        $modelPersona->usuario_creacion_id = Yii::app()->user->id;
                        $modelPersona->usuario_actualizacion_id = NULL;
                        $modelPersona->sucursal_id = count($modelSucursal) == 0 ? Util::getSucursal() : $modelSucursal->id;
                        if (!$modelPersona->save()) {//

                            $errors[]=array('data'=>$data,'model'=>$modelPersona->attributes,'errors'=>$modelPersona->errors);

                        }
                    } else {
                        /* actualizacion de Socio */
                        $modelPersona->primer_nombre = ucwords(utf8_encode($data[2]));
                        $modelPersona->segundo_nombre = ucwords(utf8_encode($data[3]));
                        $modelPersona->apellido_paterno = ucwords(utf8_encode($data[0]));
                        $modelPersona->apellido_materno = ucwords(utf8_encode($data[1]));
                        $modelPersona->fecha_actualizacion = Util::FechaActual();
                        $modelPersona->usuario_actualizacion_id = Yii::app()->user->id;
                        $modelPersona->sucursal_id = count($modelSucursal) == 0 ? Util::getSucursal() : $modelSucursal->id;

                        if (!$modelPersona->save()) {
                            $errors[]=array('data'=>$data,'model'=>$modelPersona->attributes,'errors'=>$modelPersona->errors);

//                            $errors[]=array('model'=>$modelPersona->attributes,'errors'=>$modelPersona->errors);

                        }
                    }
                }
                $contador++;
            }
            Yii::app()->user->setFlash('success', "Archivo importado correctamente.");
//            var_dump(array_column($errors,'data'),array_column($errors,'model'),array_column($errors,'errors'));
//            die();
// Hago commit de la transaccion
            $transaction->commit();
        } catch (Exception $ex) {
// Si hay error hago rollback de la transaccion y no guardo nada
            echo $ex;
//            var_dump($modelPersona);
//            die();
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "El archivo tiene datos erroneos. Por favor corrijalos vuelva a intentar.");
        }
    }

    public function validadorUbicacion($modelArray, $modelActual, $tipo = null)
    {
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
    public function crearActividadEconomica($nombre)
    {
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
    public function crearDireccion($calle1 = null, $calle2 = null, $nro = null, $referencia = null, $barrio = null, $parroquia = null, $canton = null, $provincia = null)
    {
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
//        var_dump($provincia);
//Para canton
        if (count($modelCanton) == 0 && ($canton != '' || $canton != null)) {
            $modelCanton = new Canton();
            $modelCanton->scenario = 'import';
            $modelCanton->nombre = strtoupper(utf8_encode($canton)); //     
            $modelCanton->provincia_id = isset($modelProvincia->id) ? $modelProvincia->id : 0;
            $modelCanton->save();
//            var_dump($modelCanton->save());
//            var_dump($modelCanton->errors);
        } else if ($canton != '' || $canton != null) {
//            $modelCanton->nombre = strtoupper(utf8_encode($canton)); //     
            $modelCanton->provincia_id = isset($modelProvincia->id) ? $modelProvincia->id : 0;
            $modelCanton->save();
        }
//Para Parroquia
        if (count($modelParroquia) == 0 && ($parroquia != '' || $parroquia != null)) {
            $modelParroquia = new Parroquia('import');
            $modelParroquia->nombre = strtoupper(utf8_encode($parroquia));
            $modelParroquia->canton_id = isset($modelCanton->id) ? $modelCanton->id : 0;
            $modelParroquia->save();
//            var_dump($modelParroquia);
        } elseif ($parroquia != '' || $parroquia != null) {
//            $modelParroquia->nombre = strtoupper(utf8_encode($parroquia));
            $modelParroquia->canton_id = isset($modelCanton->id) ? $modelCanton->id : 0;
            $modelParroquia->save();
        }
//Para barrio
        if (count($modelBarrio) == 0 && ($barrio != '' || $barrio != null)) {

            $modelBarrio = new Barrio('import');
            $modelBarrio->nombre = strtoupper(utf8_encode($barrio));
            $modelBarrio->tipo = 'B';
            $modelBarrio->parroquia_id = isset($modelParroquia->id) ? $modelParroquia->id : 0;
            $modelBarrio->save();
//            var_dump($modelBarrio->save());
//            var_dump($modelBarrio->errors);
        } else if (($barrio != '' || $barrio != null)) {
            $modelBarrio->parroquia_id = isset($modelParroquia->id) ? $modelParroquia->id : 0;
            $modelBarrio->save();
        }

//        var_dump($modelBarrio, $modelParroquia);
        $conditionDireccion = 'calle_1=:calle1 and calle_2=:calle2 and numero=:numero ';
        $conditionParams = array(':calle1' => $calle1 ? $calle1 : '', ':calle2' => $calle2 ? $calle2 : '', ':numero' => $nro ? $nro : '');

        if (isset($modelBarrio->id) && isset($modelParroquia->id)) {

            $conditionDireccion = $conditionDireccion . ' and barrio_id=:barrio and parroquia_id=:parroquia';
            $conditionParams = array_merge($conditionParams, array(':barrio' => $modelBarrio->id, ':parroquia' => $modelParroquia->id));
        } else {
            $conditionDireccion = $conditionDireccion . ' and barrio_id=:barrio and parroquia_id=:parroquia';
            $conditionParams = array_merge($conditionParams, array(':barrio' => '', ':parroquia' => ''));
        }


        $modelDireccion = Direccion::model()->find(
            array('condition' => $conditionDireccion,
                'params' => $conditionParams
            ));
//        var_dump($modelDireccion);
//        die();

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
//                var_dump('new');
//                var_dump($modelDireccion);
//                die();
                return $modelDireccion->id;
            } else {
//                var_dump('not new');
//                var_dump($modelDireccion);
//                die();
                return $this->crearDireccion($calle1, $calle2, $nro, $referencia, $barrio, $parroquia, $canton, $provincia);
            }
        } else {
            if ($referencia != '') {
                $modelDireccion->referencia = $referencia;
            }
            if ($modelDireccion->save(false)) {
                return $modelDireccion->id;
            } else {
                return $this->crearDireccion($calle1, $calle2, $nro, $referencia, $barrio, $parroquia, $canton, $provincia);
            }
        }
    }

}
