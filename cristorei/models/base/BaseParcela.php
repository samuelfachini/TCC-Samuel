<?php

namespace app\models\base;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "parcela".
 *
 * @property integer $parcela_id
 * @property integer $pagamento_id
 * @property string $valor
 * @property integer $perc_desconto
 * @property string $data_vencimento
 * @property string $data_pagamento
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \app\models\Pagamento $pagamento
 */
abstract class BaseParcela extends \yii\db\ActiveRecord
{

    //use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pagamento_id', 'valor', 'data_vencimento'], 'required'],
            [['pagamento_id', 'perc_desconto', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['valor'], 'number'],
            [['data_vencimento', 'data_pagamento'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parcela';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parcela_id' => Yii::t('app', 'Parcela ID'),
            'pagamento_id' => Yii::t('app', 'Pagamento ID'),
            'valor' => Yii::t('app', 'Valor'),
            'perc_desconto' => Yii::t('app', 'Perc Desconto'),
            'data_vencimento' => Yii::t('app', 'Data Vencimento'),
            'data_pagamento' => Yii::t('app', 'Data Pagamento'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagamento()
    {
        return $this->hasOne(\app\models\Pagamento::className(), ['pagamento_id' => 'pagamento_id']);
    }

/**
     * @inheritdoc
     * @return type mixed
     */ 
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}