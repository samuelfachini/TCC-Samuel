<?php

namespace app\models\base;

use app\modules\sistema\models\User;
use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "sepultura".
 *
 * @property integer $sepultura_id
 * @property integer $quadra_id
 * @property integer $user_id
 * @property integer $aleia
 * @property integer $numero
 * @property string $sufixo_numero
 * @property integer $posicao_na_aleia
 * @property integer $pagamento_em_dia
 * @property string $observacoes
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property \app\models\Debito[] $debitos
 * @property \app\models\Falecido[] $falecidos
 * @property \app\models\Quadra $quadra
 * @property User $user
 */
abstract class BaseSepultura extends \yii\db\ActiveRecord
{

    //use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quadra_id', 'user_id', 'aleia', 'numero'], 'required'],
            [['quadra_id', 'user_id', 'aleia', 'numero', 'posicao_na_aleia', 'pagamento_em_dia', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['sufixo_numero'], 'string', 'max' => 1],
            [['observacoes'], 'string', 'max' => 500]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sepultura';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sepultura_id' => Yii::t('app', 'Sepultura ID'),
            'quadra_id' => Yii::t('app', 'Quadra ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'aleia' => Yii::t('app', 'Aleia'),
            'numero' => Yii::t('app', 'Numero'),
            'sufixo_numero' => Yii::t('app', 'Sufixo Numero'),
            'posicao_na_aleia' => Yii::t('app', 'Posicao Na Aleia'),
            'pagamento_em_dia' => Yii::t('app', 'Pagamento Em Dia'),
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
    public function getDebitos()
    {
        return $this->hasMany(\app\models\Debito::className(), ['sepultura_id' => 'sepultura_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFalecidos()
    {
        return $this->hasMany(\app\models\Falecido::className(), ['sepultura_id' => 'sepultura_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuadra()
    {
        return $this->hasOne(\app\models\Quadra::className(), ['quadra_id' => 'quadra_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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