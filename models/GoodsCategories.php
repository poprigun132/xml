<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods_categories".
 *
 * @property integer $id
 * @property integer $id_goods
 * @property integer $id_categorie
 * @property integer $id_shop
 * @property integer $id_model
 * @property integer $id_color
 * @property integer $sort
 * @property string $url
 * @property integer $edited
 */
class GoodsCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_categories';
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
            [['id_goods', 'id_categorie', 'id_shop', 'id_model', 'id_color', 'sort', 'url', 'edited'], 'required'],
            [['id_goods', 'id_categorie', 'id_shop', 'id_model', 'id_color', 'sort', 'edited'], 'integer'],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_goods' => 'Id Goods',
            'id_categorie' => 'Id Categorie',
            'id_shop' => 'Id Shop',
            'id_model' => 'Id Model',
            'id_color' => 'Id Color',
            'sort' => 'Sort',
            'url' => 'Url',
            'edited' => 'Edited',
        ];
    }
}
