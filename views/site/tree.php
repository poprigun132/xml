<?
use yii\web\JsExpression as js;

echo \app\widgets\fancytree\fancytree\FancytreeWidget::widget([
		'options' =>[
			'checkbox'=>true,
			'icons'=>true,
			'idPrefix' => 'tree_',
			'activate' =>  new js('
					function(event, data) {
					var node = data.node;
					$("#categoryAttr").val(node.data.titleNew);
				  }'
			),
			'selectMode'=>3,
			'source' => $cats,
			'extensions' => ['dnd'],
			'dnd' => [
				'preventVoidMoves' => true,
				'preventRecursiveMoves' => true,
				'autoExpandMS' => 400,
				'dragStart' => new js('function(node, data) { return false; }'),
				'dragEnter' => new js('function(node, data) { return false; }'),
				'dragDrop' => new js('function(node, data) { data.otherNode.moveTo(node, data.hitMode); }'),
			],
		]
	]);
