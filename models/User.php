<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use Yii;

class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string', 'max' => 255],
            ['role_id', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_USER]],
        ];
    }

    public function setPassword($password)
    {
        $this->password = sha1($password);
    }

    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public static function isUserAdmin($id)
    {
        if (static::findOne(['id' => $id, 'role_id' => self::ROLE_ADMIN]))
        {
            return true;
        } else {
            return false;
        }
    }

    public function getAuthKey() {}
    public static function findIdentityByAccessToken($token, $type = null){}
    public function validateAuthKey($authKey) {}

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'role_id' => 'Role',
        ];
    }
}
