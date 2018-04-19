<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Falecido;

/**
 * app\models\FalecidoSearch represents the model behind the search form about `app\models\Falecido`.
 */
 class FalecidoSearch extends Falecido
{
    public $sepultura_quadra_id;
    public $sepultura_aleia;
    public $sepultura_numero;
    public $sepultura_sufixo_numero;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['falecido_id', 'sepultura_id'], 'integer'],
            [['nome', 'data_nascimento', 'data_falecimento', 'data_exumacao', 'data_sepultamento', 'observacoes','sepultura_quadra_id','sepultura_aleia','sepultura_numero'], 'safe'],
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
        $query = Falecido::find()->select(['falecido.*','TIMESTAMPDIFF(YEAR, data_nascimento, data_falecimento) idade'])
        ->joinWith(['sepultura', 'sepultura.quadra']);

        $dataProvider = new ActiveDataProvider([
            //'totalCount' => Falecido::find()->count(),
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sepultura_quadra_id' => SORT_ASC, 'sepultura_aleia' => SORT_ASC, 'sepultura_numero' => SORT_ASC, 'sepultura_sufixo_numero' => SORT_ASC]]
        ]);

        $dataProvider->sort->attributes['idade'] = [
            'asc' =>['idade'=>SORT_ASC],
            'desc'=>['idade' =>SORT_DESC],
        ];

        $dataProvider->sort->attributes['sepultura_quadra_id'] = [
            'asc' =>['sepultura.quadra_id'=>SORT_ASC],
            'desc'=>['sepultura.quadra_id' =>SORT_DESC],
        ];

        $dataProvider->sort->attributes['sepultura_aleia'] = [
            'asc' =>['sepultura.aleia'=>SORT_ASC],
            'desc'=>['sepultura.aleia' =>SORT_DESC],
        ];

        $dataProvider->sort->attributes['sepultura_numero'] = [
            'asc' =>['sepultura.numero'=>SORT_ASC],
            'desc'=>['sepultura.numero' =>SORT_DESC],
        ];

        $dataProvider->sort->attributes['sepultura_sufixo_numero'] = [
            'asc' =>['sepultura.sufixo_numero'=>SORT_ASC],
            'desc'=>['sepultura.sufixo_numero' =>SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'falecido_id' => $this->falecido_id,
            'sepultura_id' => $this->sepultura_id,
            'data_nascimento' => $this->data_nascimento,
            'data_falecimento' => $this->data_falecimento,
            'data_sepultamento' => $this->data_sepultamento,
            'sepultura.quadra_id'  => $this->sepultura_quadra_id,
            'sepultura.aleia'      => $this->sepultura_aleia,
            'sepultura.numero'     => $this->sepultura_numero,
        ]);

        $query->andFilterWhere(['like', 'falecido.nome', $this->nome])
            ->andFilterWhere(['like', 'falecido.observacoes', $this->observacoes]);

        return $dataProvider;
    }
}
