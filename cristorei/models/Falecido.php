<?php

namespace app\models;

use Yii;
use \app\models\base\BaseFalecido;

/**
 * This is the model class for table "falecido".
 */
class Falecido extends BaseFalecido
{
    public $idade;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['data_falecimento'], 'compare', 'compareAttribute' => 'data_nascimento', 'operator' => '>='],
            [['data_sepultamento'], 'compare', 'compareAttribute' => 'data_falecimento', 'operator' => '>='],
            [['data_exumacao'], 'compare', 'compareAttribute' => 'data_falecimento', 'operator' => '>='],
        ]);
    }

    public function getIdade()
    {
        if (!empty($this->data_nascimento) && !empty($this->data_falecimento))
            return date_diff(date_create($this->data_falecimento), date_create($this->data_nascimento))->y . ' anos';
        else
            return null;
    }
	
}