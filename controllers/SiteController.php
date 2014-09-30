<?php

namespace app\controllers;

use app\models\Shops;
use app\models\User;
use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UrlManager;

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

    public function actionIndex($shopId = false, $templateId = false)
    {
		$urlManager = new UrlManager();
		$urlManager->enablePrettyUrl = true;
		$urlManager->showScriptName = false;

		$users = Users::find()->where(['id_user'=>Yii::$app->user->id])->one();;
		$userShops = $users->getUserShops();

		$shops = Shops::find()->where(['id_shop'=>$shopId])->one();
		$templates = [];
		if( is_object($shops) ){
			$templates = $shops->getTemplates()->all();
		}


		$_shops = [];
		foreach($userShops as $k=>$v) {
			$_shops[$k]['label'] = $v->name;
			$_shops[$k]['url'] = $urlManager->createUrl( [
					Yii::$app->requestedAction->controller->id.'/'.Yii::$app->requestedAction->id,
					'shopId'=>$v->id_shop
				] );
		}

		$_templates = [];
		foreach($templates as $k=>$v) {
			$_templates[$v->id]['label'] = $v->name;
			$_templates[$v->id]['url'] = $urlManager->createUrl( [
					Yii::$app->requestedAction->controller->id.'/'.Yii::$app->requestedAction->id,
					'shopId'=>$shopId,
					'templateId'=>$v->id
				] );
		}
		return $this->render('index', ['shops'=>$_shops, 'shopId'=>$shopId, 'templates'=>$_templates, 'templateId'=>$templateId]);
    }

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
