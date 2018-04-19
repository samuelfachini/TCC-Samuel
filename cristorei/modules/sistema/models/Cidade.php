<?php

namespace app\modules\sistema\models;

use Yii;
use \app\modules\sistema\models\base\Cidade as BaseCidade;

/**
 * This is the model class for table "cidade".
 */
class Cidade extends BaseCidade
{
    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return array_merge(parent::rules(), [
//        ]);
//    }

    public static function obterCidadeComSiglaUF($cidade_id)
    {
        if ($cidade_id) {
            $cidade      = Cidade::findOne($cidade_id);            
            return $cidade->nome . ' - ' . $cidade->estado->uf;
        }

        return false;
    }
	
}
