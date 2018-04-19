<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DiaPagamento;

/**
 * app\models\DiaPagamentoSearch represents the model behind the search form about `app\models\DiaPagamento`.
 */
 class DiaPagamentoSearch extends DiaPagamento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia_pagamento_id', 'dia'], 'integer'],
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
        $query = DiaPagamento::find();

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => DiaPagamento::find()->count(),
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'dia_pagamento_id' => $this->dia_pagamento_id,
            'dia' => $this->dia,
        ]);

        return $dataProvider;
    }
}
