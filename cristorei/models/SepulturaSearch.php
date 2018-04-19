<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sepultura;

/**
 * app\models\SepulturaSearch represents the model behind the search form about `app\models\Sepultura`.
 */
 class SepulturaSearch extends Sepultura
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sepultura_id', 'quadra_id', 'aleia', 'numero', 'pagamento_em_dia','user_id'], 'integer'],
            [['observacoes'], 'safe'],
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
        $query = Sepultura::find()->joinWith('quadra');

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => Sepultura::find()->count(),
            'query' => $query,
            'sort'=> ['defaultOrder' => ['quadra_id' => SORT_ASC, 'aleia' => SORT_ASC, 'numero' => SORT_ASC, 'sufixo_numero' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'sepultura_id' => $this->sepultura_id,
            'sepultura.quadra_id' => $this->quadra_id,
            'user_id' => $this->user_id,
            'aleia' => $this->aleia,
            'numero' => $this->numero,
            'pagamento_em_dia' => $this->pagamento_em_dia,
        ]);

        $query->andFilterWhere(['like', 'observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
