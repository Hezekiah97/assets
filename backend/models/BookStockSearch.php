<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\BookStock;

/**
 * BookStockSearch represents the model behind the search form of `backend\models\BookStock`.
 */
class BookStockSearch extends BookStock
{
  public $myPageSize;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'count', 'book_id'], 'integer'],
            [['barcode', 'isbn', 'inspector', 'stock_date'], 'safe'],
            [['myPageSize'],'safe']
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
        $query = BookStock::find();

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->pagination->pageSize = ($this->myPageSize !== NULL) ? $this->myPageSize : 1;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'count' => $this->count,
            'book_id' => $this->book_id,
        ]);

        $query->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'inspector', $this->inspector])
            ->andFilterWhere(['like', 'stock_date', $this->stock_date]);

        return $dataProvider;
    }
}
