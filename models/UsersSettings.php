<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users_settings".
 *
 * @property integer $id
 * @property integer $id_template
 * @property integer $id_shop
 */
class UsersSettings extends ActiveRecord
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
            [['id_template', 'id_shop'], 'integer'],
            [['id_shop'], 'unique']
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
}
