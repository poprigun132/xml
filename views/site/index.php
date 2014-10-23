<?php
/* @var $this yii\web\View */
/* @var $shop Shops */
$this->title = 'Страница настройки XML шаблонов';
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Shops;
use yii\helpers\Url as Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
?>
<div class="site-index">
	<div class="left-block">
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

		<?
		/**
		 * Build html form
		 */
		$form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]);?>

		<?echo $form->field($shop, 'id_shop')->label('Магазины')->widget(Select2::classname(), [
				'data' => ArrayHelper::map($shops, 'id', 'name'),
				'options' => [
					'placeholder' => 'Select ...',
				],
				'pluginEvents' =>[
					'change' => 'function() { updateCategoriesTree(); }'
				]
			]);
		?>
		<?echo $form->field($shop, 'name')->label('Выбор шаблона XML')->widget(Select2::classname(), [
				'data'=> ArrayHelper::map($templates, 'id', 'name'),
				'options' => [
					'placeholder' => 'Select ...',
				],
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
		<?echo Html::submitButton('Сгенерировать',['class'=>'btn btn-primary form-control'])?>
		<?
		/**
		 * End html form
		 */
		ActiveForm::end()
		?>
	</div>

	<div class="center-block">@@@@@@</div>
</div>
