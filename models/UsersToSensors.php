<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_to_sensors".
 *
 * @property int $user_id
 * @property int $sensor_id
 *
 * @property Sensors $sensor
 * @property User $user
 */
class UsersToSensors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_to_sensors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'sensor_id'], 'required'],
            [['user_id', 'sensor_id'], 'integer'],
            [['sensor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sensors::className(), 'targetAttribute' => ['sensor_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'sensor_id' => 'Sensor ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSensor()
    {
        return $this->hasOne(Sensors::className(), ['id' => 'sensor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
