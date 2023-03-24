<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "owners".
 *
 * @property int $id
 * @property string $name
 * @property string $comment
 * @property int $asset_id
 * @property int $issued_by
 * @property int $issued_date
 * @property int|null $returned_status
 * @property int|null $returned_date
 * @property int|null $received_by
 *
 * @property Assets $asset
 * @property User $issuedBy
 * @property User $receivedBy
 */
class Owners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'owners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'asset_id', 'issued_by', 'issued_date'], 'required'],
            [['comment'], 'string'],
            [['asset_id', 'issued_by', 'issued_date', 'returned_status', 'returned_date', 'received_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['asset_id'], 'exist', 'skipOnError' => true, 'targetClass' => Assets::className(), 'targetAttribute' => ['asset_id' => 'id']],
            [['issued_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['issued_by' => 'id']],
            [['received_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['received_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'asset_id' => 'Asset Barcode',
            'issued_by' => 'Issued By',
            'issued_date' => 'Issued Date',
            'returned_status' => 'Returned Status',
            'returned_date' => 'Returned Date',
            'received_by' => 'Received By',
            'comment' => 'Comment'
        ];
    }

    /**
     * Gets query for [[Asset]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsset()
    {
        return $this->hasOne(Assets::className(), ['id' => 'asset_id']);
    }

    /**
     * Gets query for [[IssuedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIssuedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'issued_by']);
    }

    /**
     * Gets query for [[ReceivedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'received_by']);
    }
}
