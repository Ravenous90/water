<?php
/**
 * Created by PhpStorm.
 * User: askolotii
 * Date: 05.09.2018
 * Time: 16:37
 */

namespace app\models;

use yii\base\Model;

class Signin extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [ ['username', 'password'], 'required', 'message' => 'Field is required'],
            [ ['username', 'password'], 'string', 'length' => [3, 64],
                'tooShort' => 'Field must contain at least 3 symbols',
                'tooLong' => 'Field must contain no more 64 symbols' ],
            [ 'username', 'trim'],
            [ 'password', 'validatePassword'] // own function for validate password
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) { // if there are no mistakes in validation
            $user = $this->getUser(); // get user for comparison passwords

            if (!$user || !$user->validatePassword($this->password)) {
                // if there isn't user in DB
                // or password is invalid
                $this->addError($attribute, 'Username or password is invalid');
            }
        }
    }

    public function getUser()
    {
        return User::findOne(['username' => $this->username]);
    }
}