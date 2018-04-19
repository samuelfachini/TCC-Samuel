<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Debito;

/**
 * app\models\DebitoSearch represents the model behind the search form about `app\models\Debito`.
 */
 class DebitoSearch extends Debito
{
    public $sepultura_user_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debito_id', 'sepultura_id', 'pagamento_id', 'ano_ref', 'created_at', 'updated_at', 'created_by', 'updated_by','sepultura_user_id'], 'integer'],
            [['valor','situacao'], 'safe'],
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
        $query = Debito::find()->joinWith('sepultura');

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => Debito::find()->count(),
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $valorFilter = str_replace(',','.',str_replace('.','',$this->valor));

        $query->andFilterWhere([
            'debito_id' => $this->debito_id,
            'sepultura_id' => $this->sepultura_id,
            'pagamento_id' => $this->pagamento_id,
            'ano_ref' => $this->ano_ref,
            'valor' => $valorFilter,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

            'sepultura.user_id' => $this->sepultura_user_id,
        ]);

        $query->andFilterWhere(['like', 'situacao', $this->situacao]);

        return $dataProvider;
    }
}
