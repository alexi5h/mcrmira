<?php

Yii::import('crm.models._base.BasePersonaEtapa');

class PersonaEtapa extends BasePersonaEtapa {

    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';

    /**
     * @return PersonaEtapa
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function label($n = 1) {
        return Yii::t('app', 'Etapa de Socio|Etapas de Socio', $n);
    }

    public function scopes() {
        return array(
            'activos' => array(
                'condition' => 't.estado = :estado',
                'params' => array(
                    ':estado' => self::ESTADO_ACTIVO
                ),
            ),
            'orden' => array(
                'order' => 't.peso ASC',
            ),
        );
    }

    public function getPesoMaximo() {
        $command = Yii::app()->db->createCommand()
                ->select("max(t.peso)")
                ->from("persona_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO));
        $result = $command->queryColumn();
        return $result[0];
    }
    
    public function getIdPesoMinimo() {
        $command = Yii::app()->db->createCommand()
                ->select("t.id")
                ->from("persona_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO))
                ->order("t.peso desc");
        $resultMin = $command->queryColumn();
        return $resultMin[0];
    }

    public function getPersonaEtapa() {
        $command = Yii::app()->db->createCommand()
                ->select("t.id,
                        t.nombre,
                        t.peso,
                        t.estado")
                ->from("persona_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO))
                ->order("t.peso ASC");
        return ($command->queryAll());
    }

    public function getEtapaMaxima() {
        $command = Yii::app()->db->createCommand()
                ->select("t.id")
                ->from("persona_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO))
                ->order("t.peso desc")
                ->limit(1);
        return ($command->queryColumn());
    }

}
