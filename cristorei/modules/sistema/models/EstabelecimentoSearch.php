<?php

namespace app\modules\sistema\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * app\models\EstabelecimentoSearch represents the model behind the search form about `app\models\Estabelecimento`.
 */
 class EstabelecimentoSearch extends Estabelecimento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['estabelecimento_id', 'cidade_id', 'ativo', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['nome', 'nr_cpf_cnpj', 'logradouro', 'numero', 'complemento', 'bairro', 'cep', 'telefone_comercial', 'telefone_celular', 'email', 'observacao'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Estabelecimento::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'estabelecimento_id' => $this->estabelecimento_id,
            'cidade_id' => $this->cidade_id,
            'ativo' => $this->ativo,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'nr_cpf_cnpj', $this->nr_cpf_cnpj])
            ->andFilterWhere(['like', 'logradouro', $this->logradouro])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'complemento', $this->complemento])
            ->andFilterWhere(['like', 'bairro', $this->bairro])
            ->andFilterWhere(['like', 'cep', $this->cep])
            ->andFilterWhere(['like', 'telefone_comercial', $this->telefone_comercial])
            ->andFilterWhere(['like', 'telefone_celular', $this->telefone_celular])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'observacao', $this->observacao]);

        return $dataProvider;
    }
}
