<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buildings".
 *
 * @property int $id
 * @property string $name
 *
 * @property Floors[] $floors
 */
class Buildings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buildings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Building name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloors()
    {
        return $this->hasMany(Floors::className(), ['building_id' => 'id']);
    }
}
