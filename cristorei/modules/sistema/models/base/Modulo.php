<?php

namespace app\modules\sistema\models\base;

use Yii;


/**
 * This is the base model class for table "modulo".
 *
 * @property integer $modulo_id
 * @property string $nome
 */
class Modulo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 60]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modulo';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'modulo_id' => Yii::t('app', 'Modulo ID'),
            'nome' => Yii::t('app', 'Nome'),
        ];
    }
}