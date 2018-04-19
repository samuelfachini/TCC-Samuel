<?php

namespace app\modules\sistema\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\sistema\models\Modulo;

/**
 * app\modules\sistema\models\ModuloSearch represents the model behind the search form about `app\modules\sistema\models\Modulo`.
 */
 class ModuloSearch extends Modulo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modulo_id'], 'integer'],
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
        $query = Modulo::find();

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
            'modulo_id' => $this->modulo_id,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome]);

        return $dataProvider;
    }
}
