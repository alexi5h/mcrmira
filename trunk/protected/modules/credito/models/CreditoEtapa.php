<?php

Yii::import('credito.models._base.BaseCreditoEtapa');

class CreditoEtapa extends BaseCreditoEtapa
{
    const ESTADO_ACTIVO = 'ACTIVO';
    const ESTADO_INACTIVO = 'INACTIVO';
    /**
     * @return CreditoEtapa
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'Etapa de Crédito|Etapas de Crédito', $n);
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
                ->from("credito_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO));
        $result = $command->queryColumn();
        return $result[0];
    }
    
    public function getCreditoEtapa() {
        $command = Yii::app()->db->createCommand()
                ->select("t.id,
                        t.nombre,
                        t.peso,
                        t.estado")
                ->from("credito_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO))
                ->order("t.peso ASC");
        return ($command->queryAll());
    }
    
    public function getIdPesoMinimo() {
        $command = Yii::app()->db->createCommand()
                ->select("t.id")
                ->from("credito_etapa t")
                ->where("t.estado = :estado", array(':estado' => self::ESTADO_ACTIVO))
                ->order("t.peso asc")
                ->limit(1);
        $resultMin = $command->queryColumn();
        return $resultMin[0];
    }

}