<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access_shops".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_shop
 */
class AccessShops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_shops';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_AP');
    }

	public function getShops()
	{
		return $this->hasMany('app\models\Shops', ['id_shop' => 'id_shop']);
		// Первый параметр – это у нас имя класса, с которым мы настраиваем связь.
		// Во втором параметре в виде массива задаётся имя удалённого PK ключа  (id) и FK из текущей таблицы модели, которые связываются между собой
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_shop'], 'required'],
            [['id_user', 'id_shop'], 'integer'],
            [['id_user', 'id_shop'], 'unique', 'targetAttribute' => ['id_user', 'id_shop'], 'message' => 'The combination of Id User and Id Shop has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_shop' => 'Id Shop',
        ];
    }
}
