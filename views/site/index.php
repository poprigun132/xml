<?php
/* @var $this yii\web\View */
$this->title = 'Кабинет настройки XML шаблонов';
?><?Yii::$app->request->getQueryParams()?>
<div class="site-index">
	<div class="left-block"><?
		echo \yii\bootstrap\Nav::widget([
				'options' => ['class' => 'nav nav-pills'],
				'items' => [
					[
						'label' => '< url >',
						'url' => ['site/index'],
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
		?>
		<?= \yii\bootstrap\ButtonDropdown::widget([
				'label' => $shopId != '' ? $shops[$shopId]['label'] : 'Выбор Магазина',
				'options' => [
					'class'=>'choose-shop'
				],
				'dropdown' => [
					'items' => $shops,
				],
			]);
		?>
	</div>

	<div class="center-block">@@@@@@</div>
</div>
