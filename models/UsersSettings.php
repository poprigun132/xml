<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_settings".
 *
 * @property integer $id
 * @property integer $id_template
 * @property integer $id_shop
 */
class UsersSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_template', 'id_shop'], 'required'],
            [['id_template', 'id_shop'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_template' => 'Id Template',
            'id_shop' => 'Id Shop',
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
