<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "disposal".
 *
 * @property int $id
 * @property int $asset_id
 * @property int $disposed_by
 * @property string $dispose_date
 * @property string $comment
 *
 * @property Assets $asset
 * @property User $disposedBy
 */
class Disposal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asset_id', 'disposed_by', 'dispose_date', 'comment'], 'required'],
            [['asset_id', 'disposed_by'], 'integer'],
            [['comment'], 'string'],
            [['dispose_date'], 'string', 'max' => 50],
            [['asset_id'], 'exist', 'skipOnError' => true, 'targetClass' => Assets::className(), 'targetAttribute' => ['asset_id' => 'id']],
            [['disposed_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['disposed_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'asset_id' => 'Asset ID',
            'disposed_by' => 'Disposed By',
            'dispose_date' => 'Dispose Date',
            'comment' => 'Comment',
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
     * Gets query for [[DisposedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDisposedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'disposed_by']);
    }
}
