<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "model_settings".
 *
 * @property integer $id
 * @property integer $id_template
 * @property integer $id_model
 * @property integer $id_marketplace
 * @property integer $id_parent
 * @property integer $counter
 */
class ModelSettings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_template', 'id_model'], 'required'],
            [['id_template', 'id_model', 'id_marketplace', 'id_parent', 'counter'], 'integer'],
            [['id_template', 'id_model'], 'unique', 'targetAttribute' => ['id_template', 'id_model'], 'message' => 'The combination of Id Template and Id Model has already been taken.']
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
            'id_model' => 'Id Model',
            'id_marketplace' => 'Id Marketplace',
            'id_parent' => 'Id Parent',
            'counter' => 'Counter',
        ];
    }

	/**
	 * Get models settings
	 *
	 * @param int $template
	 * @param array $parentsModels
	 *
	 * @return array
	 */
	public static function getModelsSettings($template,$parentsModels = []){
		$models = [];
		$andiModels = Models::find()->asArray()->all();
		$mergeModels = ArrayHelper::index(ArrayHelper::merge($parentsModels,$andiModels),'id_model');
		$modelsSettings = ArrayHelper::index(ModelSettings::findAll(['id_template'=>$template]),'id_model');
		foreach($mergeModels as $key=>$value){
			if(ArrayHelper::keyExists($key,$modelsSettings)){
				$checked = 1;
				$marketplace = $modelsSettings[$key]['id_marketplace'];
				$parent = $modelsSettings[$key]['id_parent'];
				$count = $modelsSettings[$key]['counter'];
			}else{
				$checked = 0;
				$marketplace = null;
				$parent = null;
				$count = null;
			}
			$models[$key]['id_model'] = $value['id_model'];
			$models[$key]['name'] = $value['name'];
			$models[$key]['checked'] = $checked;
			$models[$key]['marketplace'] = $marketplace;
			$models[$key]['parent'] = $parent;
			$models[$key]['count'] = $count;
		}
		return $models;
	}

	/**
	 * Save or delete select/unselect model
	 *
	 * @param int $idTemplate
	 * @param int $idModel
	 * @param bool $checked
	 * @param $marketPlace
	 * @param int $parent
	 * @param int $count
	 */

	public static function changeSelectModel($idTemplate,$idModel,$checked = true,$marketPlace,$parent,$count){

		if(!$checked){
			ModelSettings::deleteAll(['id_template'=>$idTemplate,'id_model'=>$idModel]);
		}else{
			$modelSetting = ModelSettings::findOne(['id_template'=>$idTemplate,'id_model'=>$idModel]);
			if($modelSetting == null){
				$modelSetting = new ModelSettings();
			}

			$modelSetting->id_template = $idTemplate;
			$modelSetting->id_model = $idModel;
			$modelSetting->id_marketplace = $marketPlace;
			$modelSetting->id_parent = $parent;
			$modelSetting->counter = $count;
			$modelSetting->save();
		}
	}
}
