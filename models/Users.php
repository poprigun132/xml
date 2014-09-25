<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id_user
 * @property string $login
 * @property string $password
 * @property string $hash
 * @property integer $id_role
 * @property string $name
 * @property string $nickname
 * @property string $phone
 * @property string $email
 * @property string $skype
 * @property string $icq
 * @property integer $zd
 * @property integer $status
 * @property integer $status_add_images
 * @property integer $active
 * @property integer $id_invite
 * @property integer $id_refer
 * @property integer $id_amocrm
 * @property double $percent_vkman
 * @property integer $percent_loyalty
 * @property string $vk_id
 * @property integer $motivation_status
 * @property integer $motivation_position
 * @property integer $immunity
 * @property string $time_zone
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
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
            [['login', 'password', 'hash', 'nickname', 'phone', 'email', 'skype', 'icq', 'status', 'status_add_images', 'id_amocrm', 'percent_vkman', 'vk_id'], 'required'],
            [['id_role', 'zd', 'status', 'status_add_images', 'active', 'id_invite', 'id_refer', 'id_amocrm', 'percent_loyalty', 'motivation_status', 'motivation_position', 'immunity'], 'integer'],
            [['percent_vkman'], 'number'],
            [['login', 'name'], 'string', 'max' => 256],
            [['password', 'skype'], 'string', 'max' => 32],
            [['hash', 'phone', 'email', 'vk_id'], 'string', 'max' => 255],
            [['nickname'], 'string', 'max' => 40],
            [['icq', 'time_zone'], 'string', 'max' => 10],
            [['login'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'login' => 'Логин',
            'password' => 'Пароль',
            'hash' => 'Хэш',
            'id_role' => 'Айди роли',
            'name' => 'Имя',
            'nickname' => 'Ник',
            'phone' => 'Терефон',
            'email' => 'Email',
            'skype' => 'Skype',
            'icq' => 'Icq',
            'zd' => 'Zd',
            'status' => 'Статус',
            'status_add_images' => 'Status Add Images',
            'active' => 'Active',
            'id_invite' => 'Id Invite',
            'id_refer' => 'Id Refer',
            'id_amocrm' => 'Id Amocrm',
            'percent_vkman' => 'Percent Vkman',
            'percent_loyalty' => 'Percent Loyalty',
            'vk_id' => 'Vk ID',
            'motivation_status' => 'Motivation Status',
            'motivation_position' => 'Motivation Position',
            'immunity' => 'Immunity',
            'time_zone' => 'Time Zone',
        ];
    }
}
