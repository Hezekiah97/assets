<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "assets".
 *
 * @property int $id
 * @property string $barcode
 * @property int $category
 * @property string $condition
 * @property int $status
 * @property string $Asset_Particular
 * @property string $Extra_note
 * @property string $RegDate
 *
 * @property Categories $category0
 * @property Owners[] $owners
 */
class Assets extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['barcode', 'category', 'condition', 'Asset_Particular'], 'required'],
            [['barcode'], 'unique', 'targetClass' => Assets::className(), 'message'=>'Barcode must be unique'],
            [['category', 'status'], 'integer'],
            [['Asset_Particular', 'Extra_note'], 'string'],
            [['barcode'], 'string', 'max' => 34],
            [['condition'], 'string', 'max' => 80],
            [['RegDate'], 'string', 'max' => 50],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category' => 'id']],
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
            'barcode' => 'Barcode',
            'category' => 'Category',
            'condition' => 'Condition',
            'status' => 'Status',
            'Asset_Particular' => 'Asset Particular',
            'Extra_note' => 'Extra Note',
            'RegDate' => 'Reg Date',
        ];
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category']);
    }

    /**
     * Gets query for [[Owners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwners()
    {
        return $this->hasMany(Owners::className(), ['asset_id' => 'id']);
    }

    
    /**
     * Gets query for [[Owners]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public static function getOwner($id)
    // {
    //     // return $this->hasOne(Owners::className(), ['asset_id' => 'id']);
    //     $is_owned = Owners::findOne(['asset_id'=>$id]);
    //     $asset_status = Assets::findOne($id)->status;

    //     if ($is_owned) {
    //       # code...
    //       if ($asset_status == 2) {
    //         return 'Disposed';
    //       }else{
    //         return $is_owned->name;
    //       }
    //     }
        
    // }

    
    public function issuedDate($asset_id){

      $owner = Owners::find()->where(['asset_id'=>$asset_id])->one();
      return $owner->issued_date;
}

public function currentOwner($asset_id){

      // $owner = Owners::find()->where(['asset_id' => $asset_id,'returned_status' => 0])->one();
      $owner = Owners::find()->where(['asset_id' => $asset_id])->one();
      $asset_status = Assets::findOne($asset_id)->status;


      if ($owner) {
        if ($asset_status == 2) {
          return 'Disposed';
        }else{
          return $owner->name;
        }
      // return $owner->name; 
      }else{
      return 'Not assigned';
      }

}

      public function initialOwner($asset_id){
            $owner = Owners::find()->where(['asset_id'=>$asset_id])->one();
            return $owner->issued_date;
      }

    public function upload()
    {
      $file = UploadedFile::getInstance($this, 'file');
  
      if ($this->rules()) {
        $tmp_file = $file->baseName . '.' . $file->extension;
        $path = 'upload/' . 'Files/Assets/';
        if (is_dir($path)) {
          $file->saveAs($path . $tmp_file);
        } else {
          mkdir($path, 0777, true);
        }
        $file->saveAs($path . $tmp_file);

        return true;
      } else {
        Return 'validation failed';
      }
    }
}
