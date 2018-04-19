<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parcela;

/**
 * app\models\ParcelaSearch represents the model behind the search form about `app\models\Parcela`.
 */
 class ParcelaSearch extends Parcela
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parcela_id', 'pagamento_id', 'perc_desconto', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['valor'], 'number'],
            [['data_vencimento', 'data_pagamento'], 'safe'],
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
        $query = Parcela::find();

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => Parcela::find()->count(),
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'parcela_id' => $this->parcela_id,
            'pagamento_id' => $this->pagamento_id,
            'valor' => $this->valor,
            'perc_desconto' => $this->perc_desconto,
            'data_vencimento' => $this->data_vencimento,
            'data_pagamento' => $this->data_pagamento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
