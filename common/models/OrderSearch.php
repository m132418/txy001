<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pay_suite', 'howmany', 'howmuch' , 'period', 'whose', 'is_payed', 'is_gen','channel', 'created_at', 'updated_at','temp1','temp2'], 'integer'],
            [['payed_sn'], 'safe'],
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
        $query = Order::find();

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
            'pay_suite' => $this->pay_suite,
            'howmany' => $this->howmany,
            'howmuch' => $this->howmuch,
            'period' => $this->period,
            'whose' => Yii::$app->user->identity->id,            
//             'is_payed' => $this->is_payed,
            'is_payed' => 1,
            
            'is_gen' => $this->is_gen,
            'channel' => $this->channel,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payed_sn', $this->payed_sn]);

        return $dataProvider;
    }
}
