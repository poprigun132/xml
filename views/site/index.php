<?php
/* @var $this yii\web\View */
$this->title = 'Кабинет настройки XML шаблонов';
?>
<div class="site-index">
	<div class="left-block"><?= \yii\bootstrap\Nav::widget([
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
		?>Магазин:<br>
		<?= \yii\bootstrap\ButtonDropdown::widget([
				'label' => $shopId != '' ? $shops[$shopId]['label'] : 'Выбор Магазина',
				'options' => [
					'class'=>'choose-shop'
				],
				'dropdown' => [
					'items' => $shops,
				],
			]);
		?><br>Шаблон<br>
		<?= \yii\bootstrap\ButtonDropdown::widget([
				'label' => $templateId != '' ? $templates[$templateId]['label'] : 'Выбор Шаблона',
				'options' => [
					'class'=>'choose-shop'
				],
				'dropdown' => [
					'items' => $templates,
				],
			]);
		?><br>
		<?php
		// Example of data.
		$data = [
			['title' => 'Node 1', 'key' => 1],
			['title' => 'Folder 2', 'key' => '38', 'lazy'=>true, 'folder' => true, 'children' => [
				['title' => 'Node 2.1', 'key' => '3'],
				['title' => 'Node 2.2', 'key' => '4']
			]]
		];

		echo \wbraganca\fancytree\FancytreeWidget::widget([
				'options' =>[
					'checkbox'=>true,
					'icons'=>true,
					'selectMode'=>3,
					'source' => $cats,
					'extensions' => ['dnd'],
					'dnd' => [
						'preventVoidMoves' => true,
						'preventRecursiveMoves' => true,
						'autoExpandMS' => 400,
						'dragStart' => new \yii\web\JsExpression('function(node, data) { return false; }'),
						'dragEnter' => new \yii\web\JsExpression('function(node, data) { return false; }'),
						'dragDrop' => new \yii\web\JsExpression('function(node, data) { data.otherNode.moveTo(node, data.hitMode); }'),
					],
				]
			]);
		?>

	</div>

	<div class="center-block">@@@@@@</div>
</div>
