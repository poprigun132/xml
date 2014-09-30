<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property integer $id
 * @property string $name
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'template', 'shopId', 'userId'], 'required'],
            [['template'], 'string'],
            [['shopId', 'userId'], 'integer'],
            [['createDate'], 'safe'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'template' => 'Template',
            'shopId' => 'Shop ID',
            'userId' => 'User ID',
            'createDate' => 'Create Date',
        ];
    }
}
