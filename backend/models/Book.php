<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $item_type
 * @property string $isbn
 * @property string $author
 * @property string $title
 * @property int $yop
 * @property string $barcode
 * @property int $qty
 * @property int $price
 * @property string $condition
 * @property string $location
 * @property int $regDate
 */
class Book extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_type', 'isbn', 'author', 'title','barcode', 'qty', 'price', 'condition'], 'required'],
            [['yop', 'qty', 'price', 'regDate'], 'integer'],
            [['item_type', 'isbn', 'author', 'title', 'barcode', 'condition','location'], 'string', 'max' => 255],
            [['file'],'file', 'skipOnEmpty' => true,'extensions' => 'xls,xlsx,csv'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_type' => 'Type',
            'isbn' => 'Isbn',
            'author' => 'Author',
            'title' => 'Title',
            'yop' => 'Yop',
            'barcode' => 'Barcode',
            'qty' => 'Qty',
            'price' => 'Price',
            'condition' => 'Condition',
            'location' => 'location',
            'regDate' => 'Reg Date',
        ];
    }

    
    public function upload()
    {
      $file = UploadedFile::getInstance($this, 'file');
  
      if ($this->rules()) {
        $tmp_file = $file->baseName . '.' . $file->extension;
        $path = 'upload/' . 'Files/';
        if (is_dir($path)) {
          $file->saveAs($path . $tmp_file);
        } else {
          mkdir($path, 0777, true);
          $file->saveAs($path . $tmp_file);
        }
        return true;
      } else {
        return 'validation failed';
      }
    }
}
