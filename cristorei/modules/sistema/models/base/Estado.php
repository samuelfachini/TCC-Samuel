<?php

namespace app\modules\sistema\models\base;

use Yii;


/**
 * This is the base model class for table "estado".
 *
 * @property integer $estado_id
 * @property string $nome
 * @property string $uf
 *
 * @property \app\modules\sistema\models\Cidade[] $cidades
 */
class Estado extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estado_id', 'nome', 'uf'], 'required'],
            [['estado_id'], 'integer'],
            [['nome'], 'string', 'max' => 30],
            [['uf'], 'string', 'max' => 2],
            [['nome'], 'unique']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estado';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'estado_id' => Yii::t('app', 'Estado ID'),
            'nome' => Yii::t('app', 'Nome'),
            'uf' => Yii::t('app', 'Uf'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCidades()
    {
        return $this->hasMany(\app\modules\sistema\models\Cidade::className(), ['estado_id' => 'estado_id']);
    }
}
