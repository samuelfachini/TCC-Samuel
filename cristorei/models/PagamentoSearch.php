<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pagamento;

/**
 * app\models\PagamentoSearch represents the model behind the search form about `app\models\Pagamento`.
 */
 class PagamentoSearch extends Pagamento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pagamento_id', 'qtd_parcelas', 'perc_desconto'], 'integer'],
            [['valor_total'], 'number'],
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
        $query = Pagamento::find();

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => Pagamento::find()->count(),
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'pagamento_id' => $this->pagamento_id,
            'qtd_parcelas' => $this->qtd_parcelas,
            'valor_total' => $this->valor_total,
            'perc_desconto' => $this->perc_desconto,
        ]);

        return $dataProvider;
    }
}
