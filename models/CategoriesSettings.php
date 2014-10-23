<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories_settings".
 *
 * @property integer $id
 * @property integer $id_setting
 * @property integer $id_category
 * @property string $user_name
 */
class CategoriesSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_setting', 'id_category'], 'required'],
            [['id_setting', 'id_category'], 'integer'],
            [['user_name'], 'string', 'max' => 250],
            [['id_setting', 'id_category'], 'unique', 'targetAttribute' => ['id_setting', 'id_category'], 'message' => 'The combination of Id Setting and Id Category has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_setting' => 'Id Setting',
            'id_category' => 'Id Category',
            'user_name' => 'User Name',
        ];
    }

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('db');
	}
}
