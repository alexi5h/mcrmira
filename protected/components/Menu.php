<?php

class Menu {

    private static $_controller;

    public static function getMenu($controller) {
        self::$_controller = $controller;
        $items = array(
            array('label' => '<i class="icon-home"></i> Home', 'url' => Yii::app()->homeUrl),
            array('label' => '<i class="icon-briefcase"></i> ' . Persona::label(2), 'url' => array('/crm/persona/admin'), 'access' => 'action_persona_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'persona')),
            array('label' => '<i class="icon-money"></i>  Ahorros', 'url' => '#', 'items' => array(
                    array('label' => 'Depositos', 'url' => array('/ahorro/ahorroDeposito/admin'), 'access' => 'action_ahorroDeposito_admin', 'active_rules' => array('module' => 'ahorro', 'controller' => 'ahorroDeposito', 'action' => 'admin')),
                    array('label' => 'Consolidado', 'url' => array('/ahorro/ahorroDeposito/consolidado'), 'access' => 'action_ahorroDeposito_consolidado', 'active_rules' => array('module' => 'ahorro', 'controller' => 'ahorroDeposito', 'action' => 'consolidado')),
                )),
            array('label' => '<i class="icon-shopping-cart"></i> ' . Credito::label(2), 'url' => '#', 'items' => array(
                    array('label' => 'Consolidado', 'url' => array('/credito/credito/admin'), 'access' => 'action_credito_admin', 'active_rules' => array('module' => 'credito', 'controller' => 'credito', 'action' => 'admin')),
                    array('label' => 'Detalle Pagos', 'url' => array('/credito/creditoDeposito/admin'), 'access' => 'action_creditoDeposito_admin', 'active_rules' => array('module' => 'credito', 'controller' => 'creditoDeposito', 'action' => 'admin')),
                )),
            array('label' => '<i class="icon-exchange"></i> Retirar Ahorros', 'url' => array('/ahorro/ahorroRetiro/admin'), 'access' => 'action_ahorroRetiro_admin', 'active_rules' => array('module' => 'ahorro', 'controller' => 'ahorroRetiro')),
            array('label' => '<i class="icon-share-alt"></i> Devolución Créditos', 'url' => array('/credito/creditoDevolucion/admin'), 'access' => 'action_creditoDevolucion_admin', 'active_rules' => array('module' => 'credito', 'controller' => 'creditoDevolucion')),
//            array('label' => '<i class="icon-book"></i>  Pagos', 'url' => '#', 'items' => array(
//                array('label' => '<i class="icon-briefcase"></i> Pagos', 'url' => array('/pagos/pago/admin'), 'access' => 'action_pago_admin', 'active_rules' => array('module' => 'pagos', 'controller' => 'pago')),
//                array('label' => '<i class="icon-briefcase"></i> Depositos', 'url' => array('/pagos/deposito/admin'), 'access' => 'action_deposito_admin', 'active_rules' => array('module' => 'pagos', 'controller' => 'deposito')),
//            )),
//            array('label' => '<i class="icon-fire-extinguisher"></i>Historial Incidencias', 'url' => array('/incidencias/incidencia/historial'), 'access' => 'action_incidencia_historial', 'active_rules' => array('module' => 'incidencias', 'controller' => 'incidencia', 'action' => 'historial'), 'visible' => (Yii::app()->user->checkAccess(Constants::ROL_ESPECIALISTA)) && !Yii::app()->user->checkAccess(Constants::ROL_ESPECIALISTA)),
////            array('label' => '<i class="icon-rocket"></i>  Gestiona Campaña', 'url' => array('/campanias/campania/gestionOperadorAcciones/idCampania/2/'), 'access' => 'action_campania_gestionOperadorAcciones', 'active_rules' => array('module' => 'campanias'),'visible'=>(!Yii::app()->user->isSuperAdmin)&&(Util::validarRol(Util::getRolUser(Yii::app()->user->id), array(Constants::ROL_OPERADOR)))),
//            array('label' => '<i class="icon-rocket"></i>  Gestiona Campaña', 'url' => array('/campanias/campania/campaniasRoles'), 'access' => 'action_campania_campaniasRoles', 'active_rules' => array('module' => 'campanias'),'visible'=>(!Yii::app()->user->isSuperAdmin)&&(Util::validarRol(Util::getRolUser(Yii::app()->user->id), array(Constants::ROL_OPERADOR)))),
//            array('label' => '<i class="icon-globe"></i> Marketing', 'url' => array('/marketing/default/index'), 'active_rules' => array('module' => 'marketing')),
//            array('label' => '<i class="icon-folder-open"></i> Proyectos', 'url' => array('/proyectos/default/index'), 'active_rules' => array('module' => 'proyecto')),
//            array('label' => '<i class="icon-shopping-cart"></i> Productos', 'url' => array('/productos/default/index'), 'active_rules' => array('module' => 'producto')),
//            array('label' => '<i class="icon-truck"></i> Courier', 'url' => array('/courier/default/index'), 'active_rules' => array('module' => 'courier')),
        );

        return self::generateMenu($items);
    }

    public static function getAdminMenu($controller) {
        self::$_controller = $controller;
        $items = array(
            array('label' => '<i class="icon-mail-reply"></i>  Regresar a la App', 'url' => Yii::app()->homeUrl),
            array('label' => '<i class="icon-user"></i>  Usuarios', 'url' => Yii::app()->user->ui->userManagementAdminUrl, 'access' => 'Cruge.ui.*', 'active_rules' => array('module' => 'cruge')),
            array('label' => '<i class="icon-map-marker"></i>  Catálogos', 'url' => '#', 'items' => array(
                    array('label' => 'Provincias', 'url' => array('/crm/provincia/admin'), 'access' => 'action_provincia_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'provincia')),
                    array('label' => 'Cantones', 'url' => array('/crm/canton/admin'), 'access' => 'action_canton_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'canton')),
                    array('label' => 'Parroquias', 'url' => array('/crm/parroquia/admin'), 'access' => 'action_parroquia_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'parroquia')),
                    array('label' => 'Barrios', 'url' => array('/crm/barrio/admin'), 'access' => 'action_barrio_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'barrio')),
                )),
            array('label' => '<i class="icon-dollar"></i>  Entidades', 'url' => '#', 'items' => array(
                    array('label' => 'Entidad Bancaria', 'url' => array('/crm/entidadBancaria/admin'), 'access' => 'action_entidadBancaria_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'entidadBancaria')),
                    array('label' => 'Sucursal', 'url' => array('/crm/sucursal/admin'), 'access' => 'action_sucursal_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'sucursal')),
                )),
//            array('label' => '<i class="icon-tasks"></i>  Etapa Gestión', 'url' => '#', 'items' => array(
//                    array('label' => 'Etapa Registro', 'url' => array('/crm/personaEtapa/admin'), 'access' => 'action_personaEtapa_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'personaEtapa')),
//                    array('label' => 'Etapa Crédito', 'url' => array('/credito/creditoEtapa/admin'), 'access' => 'action_creditoEtapa_admin', 'active_rules' => array('module' => 'credito', 'controller' => 'creditoEtapa')),
//                )),
            array('label' => '<i class="icon-leaf"></i> Actividad Económica', 'url' => array('/crm/actividadEconomica/admin'), 'access' => 'action_actividadEconomica_admin', 'active_rules' => array('module' => 'crm', 'controller' => 'actividadEconomica')),
            array('label' => '<i class="icon-upload-alt"></i> Importar CSV', 'url' => array('/importCsv/'), 'access' => 'action_actividadEconomica_admin', 'active_rules' => array('module' => 'importCsv', 'controller' => 'default')),
        );

        return self::generateMenu($items);
    }

    /**
     * Function to create a menu with acces rules and active item
     * @param array $items items to build the menu
     * @return array the formated menu
     */
    private static function generateMenu($items) {
        $menu = array();

        foreach ($items as $k => $item) {
            $access = false;
            $menu_item = $item;

            // Check children access
            if (isset($item['items'])) {
                $menu_item['items'] = array();
                // Check childrens access
                foreach ($item['items'] as $j => $children) {
                    if ($access = Yii::app()->user->checkAccess($children['access'])) {
                        $menu_item['items'][$j] = $children;
                        if (isset($children['active_rules']) && self::getActive2($children['active_rules'])) {
                            $menu_item['items'][$j]['active'] = true;
                            $menu_item['active'] = true;
                        }
                    }
                }
            } else {
                // Check item access
                if (isset($item['access'])) {
                    $access = Yii::app()->user->checkAccess($item['access']);
                } else {
                    $access = true;
                }
                // Check active
                if (isset($item['active_rules'])) {
                    $menu_item['active'] = self::getActive2($item['active_rules']);
                }
            }

            // If acces to the item or any child add to the menu
            if ($access) {
                $menu[] = $menu_item;
            }
        }

        return $menu;
    }

    /**
     * Function to compare the menu active rules with the current url
     * @param array $active_rules the array of rules to compare
     * @return boolean true if the rules match the current url
     */
//    private static function getActive($active_rules) {
//        $current = false;
//
//        if (self::$_controller) {
//            if (is_array(current($active_rules))) {
//                foreach ($active_rules as $rule) {
//                    $operator = isset($rule['operator']) ? $rule['operator'] : '==';
//
//                    if (isset($rule['module']) && self::$_controller->module) {
//                        if ($operator == "==")
//                            $current = self::$_controller->module->id == $rule['module'];
//                        if ($operator == "!=")
//                            $current = self::$_controller->module->id != $rule['module'];
//                    }
//                    if (isset($rule['controller'])) {
//                        if ($operator == "==")
//                            $current = self::$_controller->id == $rule['controller'];
//                        if ($operator == "!=")
//                            $current = self::$_controller->id != $rule['controller'];
//                    }
//                    if (isset($rule['action'])) {
//                        if ($operator == "==")
//                            $current = self::$_controller->action->id == $rule['action'];
//                        if ($operator == "!=")
//                            $current = self::$_controller->action->id != $rule['action'];
//                    }
//
//                    if (!$current)
//                        break;
//                }
//            } else {
//                $operator = isset($active_rules['operator']) ? $active_rules['operator'] : '==';
//
//                if (isset($active_rules['module']) && self::$_controller->module) {
//                    if ($operator == "==")
//                        $current = self::$_controller->module->id == $active_rules['module'];
//                    if ($operator == "!=")
//                        $current = self::$_controller->module->id != $active_rules['module'];
//                }
//                if (isset($active_rules['controller'])) {
//                    if ($operator == "==")
//                        $current = self::$_controller->id == $active_rules['controller'];
//                    if ($operator == "!=")
//                        $current = self::$_controller->id != $active_rules['controller'];
//                }
//                if (isset($active_rules['action'])) {
//                    if ($operator == "==")
//                        $current = self::$_controller->action->id == $active_rules['action'];
//                    if ($operator == "!=")
//                        $current = self::$_controller->action->id != $active_rules['action'];
//                }
//            }
//        }
//        return $current;
//    }


    private static function getActive2($active_rules) {
        $current = false;
        //MODULE
        $module = false;
        //CONTROLLER
        $controller = FALSE;
        //ACTION
        $action = false;
        if (self::$_controller) {
            if (is_array(current($active_rules))) {
                foreach ($active_rules as $rule) {
                    $operator = isset($rule['operator']) ? $rule['operator'] : '==';
                    if (isset($rule['module'])) {
                        if (self::$_controller->module) {
                            $module = self::BooleanOperator($operator, self::$_controller->module->id, $rule['module']);
                        }
                    } else {
                        $module = true;
                    }
                    if (isset($rule['controller'])) {
                        $controller = self::BooleanOperator($operator, self::$_controller->id, $rule['controller']);
                    } else {
                        $controller = true;
                    }
                    if (isset($rule['action'])) {
                        $action = self::BooleanOperator($operator, self::$_controller->action->id, $rule['action']);
                    } else {
                        $action = true;
                    }
                    if (!isset($rule['controller']) && !isset($rule['module']) && !isset($rule['action']))
                        $current = false;
                    else
                        $current = $module && $controller && $action;
                    if (!$current)
                        break;
                }
            } else {
                $operator = isset($active_rules['operator']) ? $active_rules['operator'] : '==';
                if (isset($active_rules['module'])) {
                    if (self::$_controller->module) {
                        $module = self::BooleanOperator($operator, self::$_controller->module->id, $active_rules['module']);
                    }
                } else {
                    $module = true;
                }
                if (isset($active_rules['controller'])) {
                    $controller = self::BooleanOperator($operator, self::$_controller->id, $active_rules['controller']);
                } else {
                    $controller = true;
                }
                if (isset($active_rules['action'])) {
                    $action = self::BooleanOperator($operator, self::$_controller->action->id, $active_rules['action']);
                } else {
                    $action = true;
                }
                if (!isset($active_rules['controller']) && !isset($active_rules['module']) && !isset($active_rules['action']))
                    $current = false;
                else
                    $current = $module && $controller && $action;
//                var_dump($current);
            }
        }
        return $current;
    }

    private static function BooleanOperator($operator, $compare1, $compare2) {
        $result = FALSE;
        if ($operator == "==")
            $result = $compare1 == $compare2;
        if ($operator == "!=")
            $result = $compare1 != $compare2;

        return $result;
    }

}
