<?php
/**
 * Created by PhpStorm.
 * User: poprigun
 * Date: 27.10.14
 * Time: 13:32
 */

/* @var $this yii\web\View */
/* @var $encodes */
/* @var $tempEncode selected encode*/
/* @var $tempSort selected sort*/
/* @var $currency */
/* @var $sort */
use \yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>

<div class="mainData">
	<?echo Html::tag('h1','Основные настройки',['class'=>'text-center'])?>

	<?echo Html::beginTag('div',['class'=>'group-data'])?>
		<?echo Html::label('Кодировка файла',null,['class'=>'col-lg-3 padding-top-ten'])?>
		<?echo Select2::widget([
				'name' => 'templateEncode',
				'value' =>$tempEncode,
				'data' => ArrayHelper::map($encodes, 'id', 'name'),
				'options' => [
					'placeholder' => 'Select ...',
					'style' => 'width:75%',
					'class' => 'pull-right',
					'id' => 'templateEncode',
					'onchange' =>'saveTemplateEncode(this.options[this.selectedIndex].value)',
				],
			]);
		?>
	<?echo Html::endTag('div')?>

	<?echo Html::beginTag('div',['class'=>'group-data'])?>
		<?echo Html::label('Валюта',null,['class'=>'col-lg-3 '])?>
		<?echo Html::checkboxList('currency',null,ArrayHelper::map($currency,'name','name'),[
				'class'=>'col-lg-9 main-settings-checkbox',
			])?>
	<?echo Html::endTag('div')?>

	<?echo Html::beginTag('div',['class'=>'group-data'])?>
		<?echo Html::label('Валюта площадки',null,['class'=>'col-lg-3 '])?>
	<?echo Html::endTag('div')?>

	<?echo Html::beginTag('div',['class'=>'group-data'])?>
		<?echo Html::label('Сортировка',null,['class'=>'col-lg-3 padding-top-ten'])?>
		<?echo Select2::widget([
				'name' => 'templateSort',
				'value' => $tempSort,
				'data' => ArrayHelper::map($sort, 'id', 'name'),
				'options' => [
					'placeholder' => 'Select ...',
					'style' => 'width:75%',
					'class' => 'pull-right',
					'id' => 'templateSort',
					'onchange' =>'saveTemplateSort(this.options[this.selectedIndex].value)',
				],
			]);
		?>
	<?echo Html::endTag('div')?>

	<div class="inline-block">
		<?echo Html::button('Далее',[
				'class'=>'btn col-lg-3 btn-primary pull-right',
				'onClick'=> 'nextBreadcrumbs()'
			]
		)?>
	</div>
</div>
