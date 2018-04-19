<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Quadra;

/**
 * app\models\QuadraSearch represents the model behind the search form about `app\models\Quadra`.
 */
 class QuadraSearch extends Quadra
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quadra_id'], 'integer'],
            [['nome'], 'safe'],
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
        $query = Quadra::find();

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => Quadra::find()->count(),
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'quadra_id' => $this->quadra_id,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome]);

        return $dataProvider;
    }
}
