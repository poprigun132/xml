<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "models_colors".
 *
 * @property integer $id_model
 * @property integer $id_shop
 * @property integer $id_color
 * @property string $image
 * @property integer $status
 * @property integer $set
 */
class ModelsColors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models_colors';
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
            [['id_model', 'id_shop', 'id_color', 'image', 'status', 'set'], 'required'],
            [['id_model', 'id_shop', 'id_color', 'status', 'set'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['id_model', 'id_shop', 'id_color', 'set'], 'unique', 'targetAttribute' => ['id_model', 'id_shop', 'id_color', 'set'], 'message' => 'The combination of Id Model, Id Shop, Id Color and Set has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_model' => 'Id Model',
            'id_shop' => 'Id Shop',
            'id_color' => 'Id Color',
            'image' => 'Image',
            'status' => 'Status',
            'set' => 'Set',
        ];
    }
}
