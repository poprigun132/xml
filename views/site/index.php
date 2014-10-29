<?php
/* @var $this yii\web\View */
/* @var $shop Shops */
$this->title = 'Страница настройки XML шаблонов';
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Shops;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\tabs\TabsX;
?>
<div class="site-index">
	<div class="left-block col-lg-3 col-lg-offset-1">
		<?= \yii\bootstrap\Nav::widget([
				'options' => ['class' => 'nav nav-pills'],
				'items' => [
					[
						'label' => '< url >',
						'url' => ['site/index'],
						'class'=>['active']
					],
					[
						'label' => '< img >',
						'url' => ['#'],
						'class'=>['active']
					],
					[
						'label' => '< sss >',
						'url' => ['#'],
						'class'=>['active']
					],
					[
						'label' => '< url >',
						'url' => ['#'],
						'class'=>['active']
					],
					[
						'label' => '< url >',
						'url' => ['#'],
						'class'=>['active']
					],
				],
			]);
		?><br>
git
		<?echo Html::label('Магазины')?>
		<?echo Select2::widget([
				'name' => 'shops',
				'value' => $value,
				'options' => [
					'placeholder' => 'Select ...',
					'id' => 'shopsIds',
				],
				'data' => ArrayHelper::map($shops, 'id', 'name'),
				'pluginEvents' =>[
					'change' => 'function(data) {
									updateCategoriesTree(data);
									saveSelectedShop(data);
								}'
				]
			]);
		?>
		<br>
		<?echo Html::label('Выбор шаблона XML')?>
		<?echo Select2::widget([
				'name' => 'templates',
				'data'=> ArrayHelper::map($templates, 'id', 'name'),
				'options' => [
					'placeholder' => 'Select ...',
					'id' => 'templates',
				],
				'pluginEvents' =>[
					'change' => 'function(data) {
									saveSelectedTemplate(data);
								}'
				]
			]);
		?>
		<br>
		<?echo Html::label('Категории магазина')?>
		<br>
		<?echo Html::input('text','categoryAttr',null,[
				'id'=>'categoryAttr',
				'class'=>'form-control',
				'placeholder'=>'Ключ категории',
			]);
		?>
		<div id="categories-tree">
			<?echo $categoriesTree?>
		</div>
		<br>
		<?echo Html::button('Сгенерировать',['class' => 'btn btn-primary form-control',
											/* 'onclick' => new js('
												  					saveSelectedTemplate();
												  				'),*/
			]);
		?>
	</div>
	<div class="center-block col-lg-8">
		<?echo TabsX::widget([
				'items' => [
						[
							'label' => 'Основные настройки',
							'content' =>'Основные настройки',
							'active'=>true,
							'linkOptions'=>[
								'data-url'=>\yii\helpers\Url::to(['/site/main-settings']),
							],
						],
						[
							'label' => 'Настройки моделей',
							'content'=> 'Настройки моделей',
							'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/model-settings'])],
						],
						[
							'label' => 'Хар-ка моделей',
							'content'=>'Хар-ка моделей',
							'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/model-characteristics'])]
						],
						[
							'label' => 'Шаблон XML',
							'content'=>' Шаблон XML',
						],
				],
				'position' => TabsX::POS_ABOVE,
				'align' => TabsX::ALIGN_CENTER,
				'bordered' => true,
				'encodeLabels' => false,
			]);?>
	</div>
</div>
