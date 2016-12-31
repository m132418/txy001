<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserInfo;

/**
 * UserInfoSearch represents the model behind the search form about `common\models\UserInfo`.
 */
class UserInfoSearch extends UserInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'vip'], 'integer'],
            [['phonenumber', 'email', 'user_name', 'password', 'pastime', 'expire_time', 'last_login', 'create_time'], 'safe'],
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
        $query = UserInfo::find();

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
            'status' => $this->status,
            'vip' => $this->vip,
            'expire_time' => $this->expire_time,
            'last_login' => $this->last_login,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'phonenumber', $this->phonenumber])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'pastime', $this->pastime]);

        return $dataProvider;
    }
}
