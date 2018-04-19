<?php

namespace app\models\base;

use Yii;


/**
 * This is the base model class for table "dia_pagamento".
 *
 * @property integer $dia_pagamento_id
 * @property integer $dia
 */
abstract class BaseDiaPagamento extends \yii\db\ActiveRecord
{

    //use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia'], 'required'],
            [['dia_pagamento_id', 'dia'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dia_pagamento';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dia_pagamento_id' => Yii::t('app', 'Dia Pagamento ID'),
            'dia' => Yii::t('app', 'Dia'),
        ];
    }
}