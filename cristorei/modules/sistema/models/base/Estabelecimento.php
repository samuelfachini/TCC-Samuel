<?php

namespace app\modules\sistema\models\base;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "estabelecimento".
 *
 * @property integer $estabelecimento_id
 * @property string $nome
 * @property string $responsavel
 * @property string $nr_cpf_cnpj
 * @property string $nr_cpf_responsavel
 * @property string $logradouro
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cep
 * @property integer $cidade_id
 * @property string $telefone_comercial
 * @property string $telefone_celular
 * @property string $email
 * @property string $ip_local
 * @property integer $ativo
 * @property string $observacao
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property \app\modules\sistema\models\Cidade $cidade
  * @property \app\modules\sistema\models\User[] $users
 */

class Estabelecimento extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'cidade_id'], 'required'],
            [['cidade_id', 'ativo', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['observacao'], 'string'],
            [['nome'], 'string', 'max' => 150],
            [['nr_cpf_cnpj', 'nr_cpf_responsavel', 'telefone_comercial'], 'string', 'max' => 50],
            [['logradouro'], 'string', 'max' => 255],
            [['numero'], 'string', 'max' => 10],
            [['complemento', 'bairro'], 'string', 'max' => 45],
            [['cep'], 'string', 'max' => 9],
            [['telefone_celular','ip_local'], 'string', 'max' => 15],
            [['email','responsavel'], 'string', 'max' => 100]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estabelecimento';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'estabelecimento_id' => Yii::t('app', 'Estabelecimento ID'),
            'nome' => Yii::t('app', 'Nome'),
            'responsavel' => Yii::t('app', 'Responsável'),
            'nr_cpf_cnpj' => Yii::t('app', 'Nr Cpf Cnpj'),
            'nr_cpf_responsavel' => Yii::t('app', 'CPF do Responsável'),
            'logradouro' => Yii::t('app', 'Logradouro'),
            'numero' => Yii::t('app', 'Numero'),
            'complemento' => Yii::t('app', 'Complemento'),
            'bairro' => Yii::t('app', 'Bairro'),
            'cep' => Yii::t('app', 'CEP'),
            'cidade_id' => Yii::t('app', 'Cidade'),
            'telefone_comercial' => Yii::t('app', 'Telefone Comercial'),
            'telefone_celular' => Yii::t('app', 'Telefone Celular'),
            'email' => Yii::t('app', 'E-mail'),
            'ip_local' => Yii::t('app', 'IP Local'),
            'ativo' => Yii::t('app', 'Ativo'),
            'observacao' => Yii::t('app', 'Observação'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCidade()
    {
        return $this->hasOne(\app\modules\sistema\models\Cidade::className(), ['cidade_id' => 'cidade_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(\app\modules\sistema\models\User::className(), ['estabelecimento_id' => 'estabelecimento_id']);
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
