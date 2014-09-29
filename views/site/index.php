<?php
/* @var $this yii\web\View */
$this->title = 'Кабинет настройки XML шаблонов';
?>
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

	</div>
	<div class="dropdown">
		<?= \yii\bootstrap\ButtonDropdown::widget([
				'label' => 'Выбор магазина',
				'dropdown' => [
					'options' => [
						'class'=>'btn-group'
					],
					'items' => [
						['label' => 'DropdownA', 'url' => '/'],
						['label' => 'DropdownB', 'url' => '#'],
					],
				],
			]);
		?>
	</div>
	<div class="center-block">@@@@@@</div>
</div>
