<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CardSuite;

/**
 * CardSuiteSearch represents the model behind the search form about `common\models\CardSuite`.
 */
class CardSuiteSearch extends CardSuite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'req_level', 'price','period', 'amount'], 'integer'],
            [['tname', 'desc'], 'safe'],
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
        $query = CardSuite::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'req_level' => $this->req_level,
            'period' => $this->period,
            'price' => $this->price,
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'tname', $this->tname])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
