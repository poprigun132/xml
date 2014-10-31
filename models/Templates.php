<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "templates".
 *
 * @property integer $id
 * @property string $name
 * @property double $general
 * @property integer $sort
 * @property integer $encode
 * @property string $template
 * @property string $createDate
 */
class Templates extends ActiveRecord
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
            [['name', 'sort', 'encode', 'template'], 'required'],
            [['general'], 'number'],
            [['sort', 'encode'], 'integer'],
            [['template'], 'string'],
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
            'general' => 'General',
            'sort' => 'Sort',
            'encode' => 'Encode',
            'template' => 'Template',
            'createDate' => 'Create Date',
        ];
    }
}
