<?php

namespace app\models\base;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "debito".
 *
 * @property integer $debito_id
 * @property integer $sepultura_id
 * @property integer $pagamento_id
 * @property integer $ano_ref
 * @property string $valor
 * @property string $situacao
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \app\models\Pagamento $pagamento
 * @property \app\models\Sepultura $sepultura
 */
abstract class BaseDebito extends \yii\db\ActiveRecord
{

    //use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sepultura_id', 'ano_ref', 'valor', 'situacao'], 'required'],
            [['debito_id', 'sepultura_id', 'pagamento_id', 'ano_ref', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['valor'], 'number'],
            [['situacao'], 'string', 'max' => 1]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'debito';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'debito_id' => Yii::t('app', 'Debito ID'),
            'sepultura_id' => Yii::t('app', 'Sepultura ID'),
            'pagamento_id' => Yii::t('app', 'Pagamento ID'),
            'ano_ref' => Yii::t('app', 'Ano Ref'),
            'valor' => Yii::t('app', 'Valor'),
            'situacao' => Yii::t('app', 'Situacao'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getSepultura()
    {
        return $this->hasOne(\app\models\Sepultura::className(), ['sepultura_id' => 'sepultura_id']);
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