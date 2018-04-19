<?php

namespace app\modules\sistema\models;

use Yii;

class RestringeEstabelecimentoQuery extends \yii\db\ActiveQuery
{
    private $_restringeEstabelecimento = true;

    public function prepare($builder)
    {
        $this->aplicaRestricoesPadrao();
        return parent::prepare($builder);
    }

    /**
     * Restrições aplicadas por padrão
     */
    private function aplicaRestricoesPadrao()
    {
        if ($this->_restringeEstabelecimento) {

            $estabelecimento_id = null;

            //console app does not have user component
            if (Yii::$app instanceof \yii\web\Application) {
                $estabelecimento_id = Yii::$app->user->getEstabelecimentoId();
            }

            if ($estabelecimento_id !== null) {
                /* @var \yii\db\ActiveRecord $modelClass */
                $modelClass = $this->modelClass;
                $this->andOnCondition(['=', $modelClass::tableName() . '.estabelecimento_id', $estabelecimento_id]);
            }
        }
    }

    /**
     * Define deve ser aplicado na query a restrição de estabelecimento corrente.
     * O valor padrão para o mesmo é 'true'.
     * @param bool $valor
     * @return $this
     */
    public function restringeEstabelecimento($valor = true)
    {
        $this->_restringeEstabelecimento = $valor;

        return $this;
    }

}

