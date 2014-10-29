<?php

namespace app\controllers;

use app\models\AccessShops;
use app\models\Categories;
use app\models\CategoriesSettings;
use app\models\Currency;
use app\models\Encoding;
use app\models\Shops;
use app\models\Sort;
use app\models\Templates;
use app\models\User;
use app\models\Users;
use app\models\UsersSettings;
use app\models\UsersTemplates;
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
		$template = Templates::findOne(['id'=>1]);
		$tempSort = empty($template->sort)?'':$template->sort;
		$tempEncode = empty($template->encode)?'':$template->encode;
		$mainSetting = $this->renderAjax('mainSettings',[
				'encodes' => Encoding::find()->asArray()->all(),
				'tempEncode' => $tempEncode,
				'currency' => Currency::find()->asArray()->all(),
				'sort' => Sort::find()->asArray()->all(),
				'tempSort' => $tempSort,
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
		$modelSetting = $this->renderAjax('modelSettings',[

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

		$mainSetting = $this->renderAjax('mainSettings',[
				'encodes' => Encoding::find()->asArray()->all(),
				'encode' => new Encoding(),
				'currency' => Currency::find()->asArray()->all(),
				'sort' => Sort::find()->asArray()->all(),
				'sortModel' => new Sort(),
			]
		);
		return $mainSetting;
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
