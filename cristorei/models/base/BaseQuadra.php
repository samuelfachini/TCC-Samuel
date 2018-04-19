<?php

namespace app\models\base;

use Yii;


/**
 * This is the base model class for table "quadra".
 *
 * @property integer $quadra_id
 * @property string $nome
 *
 * @property \app\models\Sepultura[] $sepulturas
 */
abstract class BaseQuadra extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string', 'max' => 45]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quadra';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quadra_id' => Yii::t('app', 'Quadra ID'),
            'nome' => Yii::t('app', 'Nome'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSepulturas()
    {
        return $this->hasMany(\app\models\Sepultura::className(), ['quadra_id' => 'quadra_id']);
    }
}