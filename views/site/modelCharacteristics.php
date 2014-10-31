<?php
/**
 * Created by PhpStorm.
 * User: poprigun
 * Date: 27.10.14
 * Time: 13:33
 */ 
use \yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>

<?echo Html::beginTag('div',['class'=>'modelCharacteristics'])?>
	<?echo Html::tag('h1','Характеристики моделей ',['class'=>'text-center'])?>

	<?echo Html::beginTag('div',['class'=>'group-data'])?>

	<?echo Html::endTag('div')?>

	<?echo Html::button('Далее',[
			'class'=>'btn col-lg-3 margin-left-ten btn-primary pull-right',
			'onClick'=> 'nextBreadcrumbs()'
		])
	?>
	<?echo Html::button('Назад',[
			'class'=>'btn col-lg-3 btn-primary pull-right margin-right-15',
			'onClick'=> 'prevBreadcrumbs()'
		])
	?>
<?echo Html::endTag('div')?>
