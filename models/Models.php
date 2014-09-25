<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property integer $id_model
 * @property string $name
 * @property string $description
 * @property string $price
 * @property integer $left
 * @property integer $top
 * @property integer $size
 * @property string $icon
 * @property string $sizeicon
 * @property integer $sort
 * @property integer $1c_id
 * @property string $url
 * @property double $coefficient
 */
class Models extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models';
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
            [['name', 'description', 'price', 'left', 'top', 'size', 'icon', 'sizeicon', 'sort', '1c_id'], 'required'],
            [['description'], 'string'],
            [['price', 'coefficient'], 'number'],
            [['left', 'top', 'size', 'sort', '1c_id'], 'integer'],
            [['name', 'icon', 'sizeicon'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 64],
            [['url'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_model' => 'Id Model',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'left' => 'Left',
            'top' => 'Top',
            'size' => 'Size',
            'icon' => 'Icon',
            'sizeicon' => 'Sizeicon',
            'sort' => 'Sort',
            '1c_id' => '1c ID',
            'url' => 'Url',
            'coefficient' => 'Coefficient',
        ];
    }
}
