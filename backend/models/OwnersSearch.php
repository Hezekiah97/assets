<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Owners;

/**
 * OwnersSearch represents the model behind the search form of `backend\models\Owners`.
 */
class OwnersSearch extends Owners
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'asset_id', 'issued_by', 'issued_date', 'returned_status', 'returned_date', 'received_by'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Owners::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>[ 
                'pagesize' => 5
            ]
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
            'asset_id' => $this->asset_id,
            'issued_by' => $this->issued_by,
            'issued_date' => $this->issued_date,
            'returned_status' => $this->returned_status,
            'returned_date' => $this->returned_date,
            'received_by' => $this->received_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
