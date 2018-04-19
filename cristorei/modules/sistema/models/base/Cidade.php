<?php

namespace app\modules\sistema\models\base;

use Yii;


/**
 * This is the base model class for table "cidade".
 *
 * @property integer $cidade_id
 * @property string $nome
 * @property integer $estado_id
 *
 * @property \app\modules\sistema\models\Estado $estado
 * @property \app\modules\sistema\models\Estabelecimento[] $estabelecimentos
 
 */
class Cidade extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cidade_id', 'nome', 'estado_id'], 'required'],
            [['cidade_id', 'estado_id'], 'integer'],
            [['nome'], 'string', 'max' => 50]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cidade';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cidade_id' => Yii::t('app', 'Cidade ID'),
            'nome' => Yii::t('app', 'Nome'),
            'estado_id' => Yii::t('app', 'Estado ID'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(\app\modules\sistema\models\Estado::className(), ['estado_id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstabelecimentos()
    {
        return $this->hasMany(\app\modules\sistema\models\Estabelecimento::className(), ['cidade_id' => 'cidade_id']);
    }

}
