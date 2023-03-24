<?php

namespace backend\models;

use Yii;
use backend\models\AuthAssignment;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $surname
 * @property string $firstname
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_verify
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 * @property string|null $last_login
 *
 * @property Owners[] $owners
 * @property Owners[] $owners0
 */
class User extends \yii\db\ActiveRecord
{
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
            'password_verify' => 'Password Verify',
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
     * Gets query for [[Owners]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwners()
    {
        return $this->hasMany(Owners::className(), ['issued_by' => 'id']);
    }

    /**
     * Gets query for [[Owners0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwners0()
    {
        return $this->hasMany(Owners::className(), ['received_by' => 'id']);
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
        $time = date('d-m-Y',$timestamp);
        return $time; 
    }
    return '';

    }

    public static function getUsername($id){
        $user = User::findOne($id);
        if ($user) {
        return $user->firstname.' '.$user->surname;
        }else{
            return '';
        }

    }
    public static function getRole($id){
        $role = AuthAssignment::findOne(['user_id'=>$id]);
        if($role){
            return $role->item_name;
        }else {
            return '';
        }
     }

     public static function setDate($date){
         return date('d-m-Y',strtotime(str_replace('-','/',$date)));
     }

     public static function getDate($date){
        return date('m/d/Y',strtotime(str_replace('/','-',$date)));
    }
}
