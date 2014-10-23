<?php

namespace app\controllers;

use app\models\AccessShops;
use app\models\Categories;
use app\models\Shops;
use app\models\Templates;
use app\models\User;
use app\models\Users;
use app\models\UsersTemplates;
use Yii;
use yii\base\Exception;
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
		/*
		$urlManager = new UrlManager();
		$urlManager->enablePrettyUrl = true;
		$urlManager->showScriptName = false;
		*/
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
		/*	$_shops[$k]['url'] = $urlManager->createUrl( [
					Yii::$app->requestedAction->controller->id.'/'.Yii::$app->requestedAction->id,
					'shopId'=>$v->id_shop,
					'templateId'=>$templateId,
				] );*/
		}

		foreach($userTemplates as $k=>$v) {
			$templates[$v->id]['name'] = $v->name;
			$templates[$v->id]['id'] = $v->id;
		/*	$_templates[$v->id]['url'] = $urlManager->createUrl( [
					Yii::$app->requestedAction->controller->id.'/'.Yii::$app->requestedAction->id,
					'shopId'=>$shopId,
					'templateId'=>$v->id
			] );*/
		}
		$tree = $this->renderPartial('tree',['cats'=>[]]);
		return $this->render('index', [
										'shops'=>$shops,
										'shopId'=>$shopId,
										'templates'=>$templates,
										'templateId'=>$templateId,
									    'categoriesTree'=>$tree,
										'shop'=> new Shops(),
			]
		);
    }

	/**
	 * Rebuild shop categories
	 * @return string
	 */
	public function actionChangeShop(){
		$idShop = Yii::$app->request->post('idShop');
		$shopsCategories = Shops::findOne(['id_shop'=>$idShop]);
		$categoriesTree = Categories::getCategoriesTree($shopsCategories->shopsCategories);
		return $this->renderAjax('tree',['cats'=>$categoriesTree]);
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

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
