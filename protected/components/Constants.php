<?php

/*
 * @author Alex Yepez <ayepez@tradesystem.com.ec>
 * clase para el manejo de constantes de producción para todo el proyecto 
 */

class Constants {

    //constantes
    //constante para el envío de mails
    const SEND_MAILS = false;
    //constante para el envío de sms
    const SEND_SMS = false;

    /* Key para Mandrill App */
    const KEY_MANDRILLAPP = "geLwclGctKoLT8n4Us5ZkQ";

    /**
     * Perfiles de usuarios 
     */
    const ROL_ADMINISTRADOR = "ADMINISTRADOR";
    const ROL_SUPERVISOR = "SUPERVISOR";
    const ROL_REPORTES = "REPORTES";
    const ROL_OPERADOR = "OPERADOR";
    const ROL_ESPECIALISTA = "ESPECIALISTA";

    //array de roles y códigos
    public static $codigoRoles = array(
        1 => self::ROL_ADMINISTRADOR,
        2 => self::ROL_SUPERVISOR,
        3 => self::ROL_REPORTES,
        4 => self::ROL_OPERADOR,
        5 => self::ROL_ESPECIALISTA,
    );

    /*     * Medios de Envio Mail* */

    const MAIL_MANDRILL = "MANDRILL";
    const MAIL_YIIMAILER = "YIIMAILER";

    /*     * Medios de envio de sms* */
    const SMS_MEDIO_SOAP = "NORMAL";

    /* Array Medios de envio MAIL */

    public static $codigoMail = array(
        1 => array('id' => 1, 'nombre' => self::MAIL_MANDRILL),
        2 => array('id' => 2, 'nombre' => self::MAIL_YIIMAILER),
    );

    /* Array Medios de envio SMS */
    public static $mediosEnvioSms = array(
        1 => array('id' => 1, 'nombre' => self::SMS_MEDIO_SOAP),
    );

    /**
     * @author Alex Yepez <ayepez@tradesystem.com.ec>
     * Costantes de lotificación 
     */
    /* ACCIONES */
    //tamaño del lote para envío de email 
    const BATCH_ACTION_EMAIL = 1000;
    //tamaño del lote para envío de sms 
    const BATCH_ACTION_SMS = 1000;
    /* REGISTROS */
    //tamaño del lote para el registro de filas
    const BATCH_ENTITY_NUMBER = 1000;

}
