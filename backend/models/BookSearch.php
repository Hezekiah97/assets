<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Book;

/**
 * BookSearch represents the model behind the search form of `backend\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'yop', 'qty', 'price', 'regDate'], 'integer'],
            [['item_type', 'isbn', 'author', 'title', 'barcode', 'condition'], 'safe'],
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
        $query = Book::find();

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
            'yop' => $this->yop,
            'qty' => $this->qty,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'item_type', $this->item_type])
            ->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'barcode', $this->barcode])
            ->andFilterWhere(['like', 'condition', $this->condition]);
        // $query->andFilterWhere(['like', 'barcode', $this->barcode]);

        return $dataProvider;
    }
}
