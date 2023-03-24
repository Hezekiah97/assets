<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $surname
 * @property string $firstname
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string|null $last_login
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthAssignment[] $authAssignments0
 * @property AuthItem[] $authItems
 * @property Department[] $departments
 * @property AuthItem[] $itemNames
 */
class User extends \yii\db\ActiveRecord
{
     /**
     * @var UploadedFile[]
     */
    // public $new;
    // public $signature;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surname', 'firstname','email'], 'required'],
            [['surname', 'firstname'], 'string', 'max' => 255],
            // [['email'],'trim','required','string','on' => 'update'], 
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            // ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.','on' => 'create'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Surname',
            'firstname' => 'Firstname',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'last_login' => 'Last Login',
        ];
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        // return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
        $role = AuthAssignment::findOne(['user_id'=>$this]);
        if ($role) {
           return $role->item_name;
        }
        return '<span class="badge badge-danger-lighten">Not Assigned</span>';
        
    }

    /**
     * Gets query for [[AuthAssignments0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments0()
    {
        return $this->hasMany(AuthAssignment::className(), ['created_by' => 'id']);
    }

    /**
     * Gets query for [[AuthItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::className(), ['created_by' => 'id']);
    }


    /**
     * Gets query for [[ItemNames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    
    public static function setTime(){

        date_default_timezone_set("Africa/Dar_es_Salaam");
        $date = date('d-m-Y H:i');
        $timestamp = strtotime($date);
        return $timestamp;

    }

    public static function getTime($timestamp){
        if ($timestamp) {
            date_default_timezone_set("Africa/Dar_es_Salaam");
            $time = date('Y-m-d H:i:s',$timestamp);
            return $time; 
        }
        return '';
    
        }
}
