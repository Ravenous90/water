<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sensors".
 *
 * @property int $id
 * @property string $name
 * @property int $floor_id
 *
 * @property Floors $floor
 * @property UsersToSensors[] $usersToSensors
 */
class Sensors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sensors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['floor_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Floors::className(), 'targetAttribute' => ['floor_id' => 'id']],
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
            'floor_id' => 'Floor №',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloor()
    {
        return $this->hasOne(Floors::className(), ['id' => 'floor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersToSensors()
    {
        return $this->hasMany(UsersToSensors::className(), ['sensor_id' => 'id']);
    }
}
