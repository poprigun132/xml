<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $id_shop
 * @property integer $parent_id
 * @property integer $position
 * @property integer $left
 * @property integer $right
 * @property integer $level
 * @property string $title
 * @property string $type
 * @property string $url
 * @property string $description
 * @property string $keywords
 * @property string $metatitle
 * @property string $metadescription
 * @property integer $useronly
 * @property string $image
 * @property integer $invisible
 * @property integer $old_id
 * @property integer $no_delete
 * @property integer $default_model
 * @property integer $hide_desc_header
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
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
            [['id_shop', 'parent_id', 'title', 'description', 'keywords', 'metadescription'], 'required'],
            [['id_shop', 'parent_id', 'position', 'left', 'right', 'level', 'useronly', 'invisible', 'old_id', 'no_delete', 'default_model', 'hide_desc_header'], 'integer'],
            [['title', 'description', 'keywords', 'metadescription'], 'string'],
            [['type', 'url', 'metatitle', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_shop' => 'Id Shop',
            'parent_id' => 'Parent ID',
            'position' => 'Position',
            'left' => 'Left',
            'right' => 'Right',
            'level' => 'Level',
            'title' => 'Title',
            'type' => 'Type',
            'url' => 'Url',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'metatitle' => 'Metatitle',
            'metadescription' => 'Metadescription',
            'useronly' => 'Useronly',
            'image' => 'Image',
            'invisible' => 'Invisible',
            'old_id' => 'Old ID',
            'no_delete' => 'No Delete',
            'default_model' => 'Default Model',
            'hide_desc_header' => 'Hide Desc Header',
        ];
    }

	public function getCategoriesTree( $shopId )
	{
		$cats = $this->find()->where(['id_shop'=>$shopId])->innerJoin( 'categories c1', 'c1.parent_id = ' )->all();
		$result = [];
		foreach($cats AS $v){
//			$result[$v->id]['title'] = $v->title;
//			$result[$v->id]['description'] = $v->description;
			$result[$v->id]['parentId'] = $v->parent_id;
			$result[$v->id]['key'] = $v->id;
		}
		$res = [];
		return $res;

	}
}
