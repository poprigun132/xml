<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id_goods
 * @property string $name
 * @property string $name_eng
 * @property string $description
 * @property string $title
 * @property string $metadescription
 * @property string $keywords
 * @property string $vector
 * @property string $price
 * @property integer $status
 * @property integer $added
 * @property integer $gave_1c
 * @property integer $fullcolor
 * @property integer $id_user
 * @property string $date
 * @property integer $sales_count
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
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
            [['name', 'name_eng', 'description', 'title', 'metadescription', 'keywords', 'vector', 'price', 'status', 'added', 'gave_1c', 'fullcolor', 'id_user', 'date'], 'required'],
            [['description', 'metadescription', 'keywords'], 'string'],
            [['price'], 'number'],
            [['status', 'added', 'gave_1c', 'fullcolor', 'id_user', 'sales_count'], 'integer'],
            [['date'], 'safe'],
            [['name', 'name_eng', 'title', 'vector'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_goods' => 'Id Goods',
            'name' => 'Name',
            'name_eng' => 'Name Eng',
            'description' => 'Description',
            'title' => 'Title',
            'metadescription' => 'Metadescription',
            'keywords' => 'Keywords',
            'vector' => 'Vector',
            'price' => 'Price',
            'status' => 'Status',
            'added' => 'Added',
            'gave_1c' => 'Gave 1c',
            'fullcolor' => 'Fullcolor',
            'id_user' => 'Id User',
            'date' => 'Date',
            'sales_count' => 'Sales Count',
        ];
    }
}
