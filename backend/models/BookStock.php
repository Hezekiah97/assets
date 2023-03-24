<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "book_stock".
 *
 * @property int $id
 * @property string $barcode
 * @property string $isbn
 * @property string $inspector
 * @property int $status
 * @property int $count
 * @property int $book_id
 * @property string $stock_date
 *
 * @property Book $book
 */
class BookStock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_stock';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barcode', 'isbn', 'inspector', 'status', 'count', 'book_id', 'stock_date'], 'required'],
            [['status', 'count', 'book_id'], 'integer'],
            [['barcode', 'isbn', 'inspector', 'stock_date'], 'string', 'max' => 255],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barcode' => 'Barcode',
            'isbn' => 'Isbn',
            'inspector' => 'Inspector',
            'status' => 'Status',
            'count' => 'Count',
            'book_id' => 'Book ID',
            'stock_date' => 'Stock Date',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
}
