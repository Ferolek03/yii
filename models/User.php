<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property int $id_gender
 * @property string $happy
 * @property string $password
 * @property int $role
 *
 * @property Gender $gender

    /**
     * {@inheritdoc}
     */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this -> password);
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function isAdmin(){
        return $this->role == 1;
    }

    public $password2;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'username', 'email', 'phone', 'id_gender', 'happy', 'password'], 'required'],
            [['id_gender', 'role'], 'integer'],
            ['password2', 'compare', 'compareAttribute' => 'password'],
            [['email'],'email'],
            ['username', 'match', 'pattern' => '/^[A-Za-z]\w*$/u', 'message'=>'Латиница'],
            ['full_name', 'match', 'pattern' => '/^[А-Яа-яЁё -]*$/u', 'message'=>'Кириллица'],
            ['username', 'unique'],
            [['happy'], 'safe'],
            [['full_name', 'username', 'email', 'phone'], 'string', 'max' => 50,],
            [['password'], 'string', 'max' => 40, 'min'=>6],
            [['id_gender'], 'exist', 'skipOnError' => true, 'targetClass' => Gender::class, 'targetAttribute' => ['id_gender' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'username' => 'Username',
            'email' => 'Email',
            'phone' => 'Phone',
            'id_gender' => 'Id Gender',
            'happy' => 'Happy',
            'password' => 'Password',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[Gender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::class, ['id' => 'id_gender']);
    }
}
