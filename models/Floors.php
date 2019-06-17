<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "floors".
 *
 * @property int $id
 * @property string $name
 * @property int $building_id
 *
 * @property Buildings $building
 * @property Sensors[] $sensors
 */
class Floors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'floors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['building_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Buildings::className(), 'targetAttribute' => ['building_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Floor №',
            'building_id' => 'Building ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Buildings::className(), ['id' => 'building_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSensors()
    {
        return $this->hasMany(Sensors::className(), ['floor_id' => 'id']);
    }
}
