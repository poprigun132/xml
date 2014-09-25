<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property integer $id
 * @property string $template
 * @property integer $shopId
 * @property integer $userId
 * @property string $createDate
 */
class Templates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template', 'shopId', 'userId'], 'required'],
            [['template'], 'string'],
            [['shopId', 'userId'], 'integer'],
            [['createDate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template' => 'Template',
            'shopId' => 'Shop ID',
            'userId' => 'User ID',
            'createDate' => 'Create Date',
        ];
    }
}
