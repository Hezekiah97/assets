<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Assets;

/**
 * AssetsSearch represents the model behind the search form of `backend\models\Assets`.
 */
class AssetsSearch extends Assets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category', 'status'], 'integer'],
            [['barcode', 'condition', 'Asset_Particular', 'Extra_note', 'RegDate'], 'safe'],
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
        $query = Assets::find();

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
            'category' => $this->category,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'condition', $this->condition])
            ->andFilterWhere(['like', 'Asset_Particular', $this->Asset_Particular])
            ->andFilterWhere(['like', 'Extra_note', $this->Extra_note])
            ->andFilterWhere(['like', 'RegDate', $this->RegDate]);

        return $dataProvider;
    }
}
