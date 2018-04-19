<?php

namespace app\models\base;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "falecido".
 *
 * @property integer $falecido_id
 * @property integer $sepultura_id
 * @property string $nome
 * @property string $sexo
 * @property string $data_nascimento
 * @property string $data_falecimento
 * @property string $data_sepultamento
 * @property string $data_exumacao
 * @property string $observacoes
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property \app\models\Sepultura $sepultura
 */
abstract class BaseFalecido extends \yii\db\ActiveRecord
{

    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sepultura_id', 'sexo'], 'required'],
            [['sepultura_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['data_nascimento', 'data_falecimento', 'data_sepultamento', 'data_exumacao'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['sexo'], 'string', 'max' => 1],
            [['observacoes'], 'string', 'max' => 500]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'falecido';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'falecido_id' => Yii::t('app', 'Falecido ID'),
            'sepultura_id' => Yii::t('app', 'Sepultura ID'),
            'nome' => Yii::t('app', 'Nome'),
            'sexo' => Yii::t('app', 'Sexo'),
            'data_nascimento' => Yii::t('app', 'Data Nascimento'),
            'data_falecimento' => Yii::t('app', 'Data Falecimento'),
            'data_sepultamento' => Yii::t('app', 'Data Sepultamento'),
            'data_exumacao' => Yii::t('app', 'Data Exumacao'),
            'observacoes' => Yii::t('app', 'Observacoes'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
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