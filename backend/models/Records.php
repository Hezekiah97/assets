<?php

namespace backend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "records".
 *
 * @property int $id
 * @property int $returned_by
 * @property int $received_by
 * @property int $returned_date
 *
 * @property Assets $asset
 * @property User $receivedBy
 * @property User $returnedBy
 */
class Records extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['returned_by', 'received_by', 'returned_date'], 'required'],
            [['returned_by', 'received_by', 'returned_date'], 'integer'],
            // ['exist', 'skipOnError' => true, 'targetClass' => Assets::className(), 'targetAttribute' => ['asset_id' => 'id']],
            [['received_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['received_by' => 'id']],
            [['returned_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['returned_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            // 'asset_id' => 'Asset ID',
            'returned_by' => 'Returned By',
            'received_by' => 'Received By',
            'returned_date' => 'Returned Date',
        ];
    }

    /**
     * Gets query for [[Asset]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getAsset()
    // {
    //     return $this->hasOne(Assets::className(), ['id' => 'asset_id']);
    // }

    /**
     * Gets query for [[ReceivedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'received_by']);
    }

    /**
     * Gets query for [[ReturnedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReturnedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'returned_by']);
    }
}
