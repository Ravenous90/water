<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sensors".
 *
 * @property int $id
 * @property string $name
 * @property int $floor_id
 * @property int $user_id
 *
 * @property Floors $floor
 * @property User $user
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
            [['floor_id', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Floors::className(), 'targetAttribute' => ['floor_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Sensor name',
            'floor_id' => 'Floor №',
            'user_id' => 'Username',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getBuildingBySensorId($id)
    {
        $floor_id = self::findOne($id)->floor_id;
        $building_id = Floors::findOne($floor_id)->building_id;
        $building_obj = Buildings::findOne($building_id);
        return $building_obj;
    }

    public static function getBuildingByFloorId($floor_id)
    {
        $building_id = Floors::findOne($floor_id)->building_id;
        $building_obj = Buildings::findOne($building_id);
        return $building_obj;
    }
}
