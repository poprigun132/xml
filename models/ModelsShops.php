<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "models_shops".
 *
 * @property integer $id_shop
 * @property integer $id_model
 * @property integer $left
 * @property integer $top
 * @property integer $size
 * @property string $icon
 * @property string $sizeicon
 * @property integer $status
 */
class ModelsShops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models_shops';
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
            [['id_shop', 'id_model', 'left', 'top', 'size', 'icon', 'sizeicon', 'status'], 'required'],
            [['id_shop', 'id_model', 'left', 'top', 'size', 'status'], 'integer'],
            [['icon', 'sizeicon'], 'string', 'max' => 255],
            [['id_shop', 'id_model'], 'unique', 'targetAttribute' => ['id_shop', 'id_model'], 'message' => 'The combination of Id Shop and Id Model has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_shop' => 'Id Shop',
            'id_model' => 'Id Model',
            'left' => 'Left',
            'top' => 'Top',
            'size' => 'Size',
            'icon' => 'Icon',
            'sizeicon' => 'Sizeicon',
            'status' => 'Status',
        ];
    }
}
