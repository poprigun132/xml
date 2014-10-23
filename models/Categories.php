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

	/**
	 * Get categories tree
	 *
	 * @param $categories
	 *
	 * @return mixed
	 */
	static public function getCategoriesTree($categories){
		$newCats = [];
		foreach($categories as $cat){
			$newCats[$cat->id]['title'] = $cat->title;
			$newCats[$cat->id]['titleNew'] = $cat->id;
			$newCats[$cat->id]['key'] = $cat->id;
			$newCats[$cat->id]['parent_id'] = $cat->parent_id;
		}
		$result = Categories::buildCategoriesTree($newCats,1);
		return $result;
	}

	/**
	 * Build categories tree
	 *
	 * @param array $categories
	 * @param int $parentId
	 *
	 * @internal param $categories
	 *
	 * @return mixed
	 */
	static private function buildCategoriesTree($categories,$parentId = 0){
		$branch = [];
		foreach ($categories as $cat) {
			$result[$cat['key']]['parentId'] = $cat['parent_id'];
			if($cat['parent_id'] == 1){
				$cat['expanded'] = true;
			}
			if ($cat['parent_id'] == $parentId) {
				$children = Categories::buildCategoriesTree($categories, $cat['key']);
				if ($children) {
					$cat['children'] = $children;
					$cat['folder'] = true;
				}
				$branch[] = $cat;
			}
		}

		return $branch;
	}
}
