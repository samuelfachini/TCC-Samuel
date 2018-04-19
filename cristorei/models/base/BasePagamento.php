<?php

namespace app\models\base;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "pagamento".
 *
 * @property integer $pagamento_id
 * @property integer $qtd_parcelas
 * @property string $primeiro_vencimento
 * @property string $valor_total
 * @property integer $perc_desconto
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property \app\models\Debito[] $debitos
 * @property \app\models\Parcela[] $parcelas
 */
abstract class BasePagamento extends \yii\db\ActiveRecord
{

    //use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qtd_parcelas', 'primeiro_vencimento', 'valor_total'], 'required'],
            [['qtd_parcelas', 'perc_desconto', 'created_at', 'created_by'], 'integer'],
            [['primeiro_vencimento'], 'safe'],
            [['valor_total'], 'number']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagamento';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pagamento_id' => Yii::t('app', 'Pagamento ID'),
            'qtd_parcelas' => Yii::t('app', 'Qtd Parcelas'),
            'primeiro_vencimento' => Yii::t('app', 'Primeiro Vencimento'),
            'valor_total' => Yii::t('app', 'Valor Total'),
            'perc_desconto' => Yii::t('app', 'Perc Desconto'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDebitos()
    {
        return $this->hasMany(\app\models\Debito::className(), ['pagamento_id' => 'pagamento_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParcelas()
    {
        return $this->hasMany(\app\models\Parcela::className(), ['pagamento_id' => 'pagamento_id']);
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
                'updatedAtAttribute' => false,
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => false,
            ],
        ];
    }
}