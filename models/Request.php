<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $id_category
 * @property int $id_user
 * @property string $gos_nomer
 * @property string $description
 * @property int $status
 * @property int $description_denied
 *
 * @property Category $category
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_category', 'id_user', 'gos_nomer', 'description', ], 'required'],
            [['id_category', 'id_user', 'status', ], 'integer'],
            [['description', 'description_denied'], 'string'],
            [['description_denied'], 'required', 'on' => 'cancel'],
            [['gos_nomer'], 'string', 'max' => 11],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_category' => 'Id Category',
            'id_user' => 'Id User',
            'gos_nomer' => 'Gos Nomer',
            'description' => 'Description',
            'status' => 'Status',
            'description_denied' => 'Description Denied',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'id_category']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['cancel'] = ['status'];
        $scenarios['success'] = ['status'];
        return $scenarios;
    }

    public function cancel(){
        $this->status=2;
        if ($this->save()){
            return true;
        }
        return false;

    }

    public function success(){
        $this->status=1;
        $this->save();
    }
}
