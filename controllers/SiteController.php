<?php

namespace app\controllers;

use app\models\AccessShops;
use app\models\Categories;
use app\models\CategoriesSettings;
use app\models\Currency;
use app\models\CurrencySettings;
use app\models\Encoding;
use app\models\Models;
use app\models\ModelSettings;
use app\models\ParentModels;
use app\models\Shops;
use app\models\Sort;
use app\models\Templates;
use app\models\User;
use app\models\Users;
use app\models\UsersSettings;
use app\models\UsersTemplates;
use Symfony\Component\Console\Helper\Helper;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UrlManager;

/**
 * Main controller
 *
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login', 'index'],
                'rules' => [

					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],

                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	/**
	 * Main action
	 *
	 * @param null $shopId
	 * @param bool $templateId
	 *
	 * @throws Exception
	 * @return string
	 */
    public function actionIndex($shopId = null, $templateId = null)
    {
		$shops = $templates = [];
		$users = Users::findOne(['id_user'=>Yii::$app->user->id]);
		$userShops = $users->userShops;
		$userShops = ArrayHelper::index($userShops, 'id_shop');
		/*if($shopId === null && !empty($userShops)){
			$shopId = current($userShops)->id_shop;
		}*/

		$userTemplates = $users->userTemplatesData;
		$userTemplates = ArrayHelper::index($userTemplates,'id');
		if($templateId === null && !empty($userTemplates)){
			$templateId = current($userTemplates)->id;
		}

		//$shopsCategories = Shops::findOne(['id_shop'=>$shopId]);
		//$categoriesTree = Categories::getCategoriesTree($shopsCategories->shopsCategories);

		foreach($userShops as $k=>$v) {
			$shops[$k]['name'] = $v->name;
			$shops[$k]['id'] = $k;
		}

		foreach($userTemplates as $k=>$v) {
			$templates[$v->id]['name'] = $v->name;
			$templates[$v->id]['id'] = $v->id;
		}
		$tree = $this->renderPartial('tree',['cats'=>[]]);

		return $this->render('index', [
										'shops' => $shops,
										'shopId' => $shopId,
										'templates' => $templates,
										'templateId' => $templateId,
									    'categoriesTree' => $tree,
										'shop' => new Shops(),
										'value'=> null,
			]
		);
    }

	/**
	 * Rebuild shop categories
	 * @return string
	 */
	public function actionChangeShop(){
		$idShop = Yii::$app->request->post('idShop');
		$shop = Shops::findOne(['id_shop'=>$idShop]);
		$categoriesTree = Categories::getCategoriesTree($shop);
		return $this->renderAjax('tree',['cats'=>$categoriesTree]);
	}

	/**
	 * Get page main settings
	 *
	 * @return string
	 */
	public function actionMainSettings(){
		$idTemplate = Yii::$app->request->get('idTemplate');
		$template = Templates::findOne(['id'=>$idTemplate]);
		$tempSort = empty($template->sort)?'':$template->sort;
		$tempEncode = empty($template->encode)?'':$template->encode;
		$encode = Encoding::find()->asArray()->all();
		$currency = Currency::find()->asArray()->all();
		$currencySettings = CurrencySettings::find()->where(['id_template'=>$idTemplate])->asArray()->all();
		$currencySettings = ArrayHelper::index($currencySettings,'id_currency');
		$selectionCurrency = [];
		foreach($currency as $key=>$value){
			if(!ArrayHelper::keyExists($value['id_currency'],$currencySettings)){
				$designation = null;
				$ratio = null;
				$defaultCurrency = null;
			}else{
				$designation = $currencySettings[$value['id_currency']]['designation'];
				$ratio = $currencySettings[$value['id_currency']]['ratio'];
				$defaultCurrency = $currencySettings[$value['id_currency']]['default_currency'];
				$selectionCurrency[$key] = $value['id_currency'];
			}
			$currency[$key]['designation'] = $designation;
			$currency[$key]['ratio'] = $ratio;
			$currency[$key]['default_currency'] = $defaultCurrency;
		}
		$sort = Sort::find()->asArray()->all();
		$mainSetting = $this->renderAjax('mainSettings',[
				'encodes' => $encode,
				'tempEncode' => $tempEncode,
				'currency' => $currency,
				'sort' => $sort,
				'tempSort' => $tempSort,
				'currencySettings' => $currencySettings,
				'selectionCurrency' => $selectionCurrency,
			]
		);
		return Json::encode($mainSetting);
	}

	/**
	 * Get page model settings
	 *
	 * @return string
	 */
	public function actionModelSettings(){
		$idTemplate = Yii::$app->request->get('idTemplate');
		$parentModels = ParentModels::find()->asArray()->all();
		$models = ModelSettings::getModelsSettings($idTemplate,$parentModels);
		$modelSetting = $this->renderAjax('modelSettings',[
				'models' => $models,
				'parentModels' => ArrayHelper::map($parentModels,'id_model','name'),
			]
		);
		return Json::encode($modelSetting);
	}

	/**
	 * Get page model characteristics
	 *
	 * @return string
	 */
	public function actionModelCharacteristics(){
		$modelSetting = $this->renderAjax('modelCharacteristics',[

			]
		);
		return Json::encode($modelSetting);
	}
	/**
	 * Save selected categories
	 */
	public function actionSaveSelectedCategories(){
		$idShop = Yii::$app->request->post('idShop');
		$categories = Yii::$app->request->post('cats',[]);

		$shop = Shops::findOne(['id_shop'=>$idShop]);
		$categories = Categories::buildSelectedCategories($shop->shopsCategories,$categories);
		$categories = array_map(function($row)use($idShop){
								return [$idShop,$row['id'], $row['select']];
			},$categories);
		CategoriesSettings::setCategorySettings($categories);
	}

	/**
	 * Save user key
	 */
	public function actionSaveUserKey(){
		$idShop = Yii::$app->request->post('idShop');
		$categoryId = Yii::$app->request->post('cat');
		$categoryKey = Yii::$app->request->post('userKey');

		$setting = CategoriesSettings::findOne(['id_shop'=>$idShop,'id_category'=>$categoryId]);
		if($setting === null){
			$setting = new CategoriesSettings();
		}
		if(empty($categoryKey)){
			$categoryKey = null;
		}
		$setting->id_category = $categoryId;
		$setting->id_shop = $idShop;
		$setting->category_key = $categoryKey;
		$setting->save();
	}

	/**
	 * Save user shop and template
	 */
	public function actionSaveUserShopTemplate(){
		$idShop = Yii::$app->request->post('idShop');
		$idTemplate = Yii::$app->request->post('idTemplate');

		$usersSettings = UsersSettings::findOne(['id_shop'=>$idShop]);
		if($usersSettings === null){
			$usersSettings = new UsersSettings();
		}
		$usersSettings->id_shop = $idShop;
		$usersSettings->id_template = $idTemplate;
		$usersSettings->save();
	}

	/**
	 * Save template encode
	 */
	public function actionSaveTemplateEncode(){
		$idTemplate = Yii::$app->request->post('idTemplate');
		$idEncode = Yii::$app->request->post('encode');

		$templates = Templates::findOne(['id'=>$idTemplate]);
		$templates->encode = $idEncode;
		$templates->save();
	}

	/**
	 * Save template sort
	 */
	public function actionSaveTemplateSort(){
		$idTemplate = Yii::$app->request->post('idTemplate');
		$idSort = Yii::$app->request->post('sort');

		$templates = Templates::findOne(['id'=>$idTemplate]);
		$templates->sort = $idSort;
		$templates->save();
	}

	/**
	 * Save template currency settings
	 */
	public function actionSaveCurrencySettings(){
		$idTemplate = Yii::$app->request->post('idTemplate');
		$idCurrency = Yii::$app->request->post('idCurrency');
		$designation = Yii::$app->request->post('designation');
		$ratio = Yii::$app->request->post('ration',1);
		$default = Yii::$app->request->post('defaultCurrency',0);

		$currencySetting = CurrencySettings::findOne(['id_template'=>$idTemplate,'id_currency'=>$idCurrency]);
		if($currencySetting === null){
			$currencySetting = new CurrencySettings();
			$currencySetting->id_template = $idTemplate;
			$currencySetting->id_currency = $idCurrency;
		}
		$currencySetting->designation = $designation;
		$currencySetting->ratio = $ratio;
		$currencySetting->default_currency = $default;
		$currencySetting->save();
	}

	/**
	 * Delete template currency
	 */
	public function actionDeleteTemplateCurrency(){
		$idTemplate = Yii::$app->request->post('idTemplate');
		$idCurrency = Yii::$app->request->post('idCurrency');
		CurrencySettings::deleteAll(['id_template'=>$idTemplate,'id_currency'=>$idCurrency]);
	}

	/**
	 * Save or delete select/unselect model
	 */
	public function actionSelectModelSettings(){
		$idTemplate = Yii::$app->request->post('idTemplate');
		$idModel = Yii::$app->request->post('idModel');
		$checked = Yii::$app->request->post('checked',1);
		$parent = Yii::$app->request->post('parent');
		$marketPlace = Yii::$app->request->post('marketPlace');
		$count = (int)Yii::$app->request->post('count',0);

		ModelSettings::changeSelectModel($idTemplate,$idModel,$checked,$marketPlace,$parent,$count);
	}
	/**
	 * @return string|\yii\web\Response
	 */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
