<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property integer $id_color
 * @property string $name
 * @property string $rgb
 * @property integer $1c_id
 */
class Colors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'rgb', '1c_id'], 'required'],
            [['1c_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['rgb'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_color' => 'Id Color',
            'name' => 'Name',
            'rgb' => 'Rgb',
            '1c_id' => '1c ID',
        ];
    }
}
