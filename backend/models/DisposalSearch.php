<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Disposal;

/**
 * DisposalSearch represents the model behind the search form of `backend\models\Disposal`.
 */
class DisposalSearch extends Disposal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'asset_id', 'disposed_by'], 'integer'],
            [['dispose_date', 'comment'], 'safe'],
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
        $query = Disposal::find();

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
            'asset_id' => $this->asset_id,
            'disposed_by' => $this->disposed_by,
        ]);

        $query->andFilterWhere(['like', 'dispose_date', $this->dispose_date])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
