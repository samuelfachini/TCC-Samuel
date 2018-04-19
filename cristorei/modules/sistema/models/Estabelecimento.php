<?php

namespace app\modules\sistema\models;

use Yii;
use \app\modules\sistema\models\base\Estabelecimento as BaseEstabelecimento;
use yiibr\brvalidator\CnpjValidator;

/**
 * This is the model class for table "estabelecimento".
 */
class Estabelecimento extends BaseEstabelecimento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['nr_cpf_cnpj', CnpjValidator::className()],
            ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'nr_cpf_cnpj' => Yii::t('app', 'CNPJ'),
        ]);
    }


	
}