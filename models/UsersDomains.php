<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_domain".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $domain_name
 * @property integer $status
 * @property integer $bind_shop
 * @property string $date_add
 */
class UsersDomains extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_domain';
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
            [['id_user', 'domain_name', 'date_add'], 'required'],
            [['id_user', 'status', 'bind_shop'], 'integer'],
            [['date_add'], 'safe'],
            [['domain_name'], 'string', 'max' => 200],
            [['domain_name'], 'unique']
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
            'domain_name' => 'Domain Name',
            'status' => 'Status',
            'bind_shop' => 'Bind Shop',
            'date_add' => 'Date Add',
        ];
    }
}
