<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id_currency
 * @property string $name
 * @property string $name_rus
 * @property double $rate
 * @property integer $readonly
 * @property string $1c_id
 */
class Currency extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_AP');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'name_rus', 'rate', 'readonly', '1c_id'], 'required'],
            [['rate'], 'number'],
            [['readonly'], 'integer'],
            [['name', 'name_rus', '1c_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_currency' => 'Id Currency',
            'name' => 'Name',
            'name_rus' => 'Name Rus',
            'rate' => 'Rate',
            'readonly' => 'Readonly',
            '1c_id' => '1c ID',
        ];
    }
}
