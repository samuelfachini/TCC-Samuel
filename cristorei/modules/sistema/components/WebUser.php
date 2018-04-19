<?php
/**
 * Created by PhpStorm.
 * User: almir
 * Date: 15/03/16
 * Time: 18:40
 */

namespace app\modules\sistema\components;


use app\modules\sistema\models\Estabelecimento;

class WebUser extends \yii\web\User
{

    const USER_ESTABELECIMENTO_ID    = 'webUser.estabelecimento_id';
    const USER_ESTABELECIMENTO_DADOS = 'webUser.estabelecimento_dados';

    /***
     * @return array|mixed ID do estabelecimento do usuário ativo
     */
    public function getEstabelecimentoId()
    {
        if ($this->getIsGuest()) {
            return [];
        }

        $userEstabelecimentoId = \Yii::$app->getSession()->get(static::USER_ESTABELECIMENTO_ID, false);

        if ($userEstabelecimentoId) {
            return $userEstabelecimentoId;
        }

        $estabelecimento_id = $this->getIdentity()->estabelecimento_id;

        \Yii::$app->getSession()->set(static::USER_ESTABELECIMENTO_ID, $estabelecimento_id);

        return $estabelecimento_id;

    }

    /***
     * @param $estabelecimento_id Estabelecimento que se deseja ativar
     */
    public function setEstabelecimentoId($estabelecimento_id)
    {
        if ($estabelecimento_id !== $this->getEstabelecimentoId()) {

            \Yii::$app->getSession()->set(static::USER_ESTABELECIMENTO_ID, $estabelecimento_id);
            \Yii::$app->getSession()->remove(static::USER_ESTABELECIMENTO_DADOS);
        }
    }

    /**
     * @param null $dado Atributo desejado (ex. 'nome_curto')
     * @return array|mixed Array com os dados do estabelecimento ou o atributo desejado
     */
    public function getEstabelecimentoDados($dado = null)
    {
        if ($this->getIsGuest()) {
            return [];
        }

        $estabelecimentoDados = \Yii::$app->getSession()->get(static::USER_ESTABELECIMENTO_DADOS, false);

        if ($estabelecimentoDados) {
            return ($dado) ? $estabelecimentoDados[$dado] : $estabelecimentoDados;
        }

        $estabelecimentoDados = Estabelecimento::find()->where(['estabelecimento_id' => $this->getEstabelecimentoId()])->asArray()->one();

        if ($estabelecimentoDados) {
            unset($estabelecimentoDados['created_at'],$estabelecimentoDados['created_by'],$estabelecimentoDados['updated_at'],$estabelecimentoDados['updated_by']);
        }


        \Yii::$app->getSession()->set(static::USER_ESTABELECIMENTO_DADOS, $estabelecimentoDados);

        return ($dado) ? $estabelecimentoDados[$dado] : $estabelecimentoDados;
    }
    
}
