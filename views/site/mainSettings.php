<?php
/**
 * Created by PhpStorm.
 * User: poprigun
 * Date: 27.10.14
 * Time: 13:32
 */

/* @var $this yii\web\View */
/* @var $encodes */
/* @var $tempEncode `saved` encode*/
/* @var $tempSort `saved` sort*/
/* @var $currency */
/* @var $sort */
use \yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
$this->registerJs('
	jQuery(function($) {
		/**
		*	Show/hide currency settings
		*/
		$("input[name^=\'currency[]\']").click(function(){
			var value = $(this).val();
			if($(this).is(":checked")){
				$(".main-setting-hidden[currency="+value+"]").addClass("show");
				saveCurrencySettings(value);
			}else{
				$(".main-setting-hidden[currency="+value+"]").removeClass("show");
				var idTemplate = $("select[name=templates] option:selected").val();
				unselectCurrency(idTemplate,value);
			}
		});
		/**
		* Save template currency settings
		*/
		$(".main-setting-hidden input").change(function(){
			var idCurrency = $(this).parents("div.main-setting-hidden").attr("currency");
			saveCurrencySettings(idCurrency);
		});

		$("input[name^=\'currency[]\']").each(function(){
			var value = $(this).val();
			if($(this).is(":checked"))
				$(".main-setting-hidden[currency="+value+"]").addClass("show");
		});
	});
');
?>

<?echo Html::beginTag('div',['class'=>'mainData'])?>
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
		<?echo Html::checkboxList('currency',$selectionCurrency,ArrayHelper::map($currency,'id_currency','name'),[
				'class'=>'col-lg-9 main-settings-checkbox',
			])?>
	<?echo Html::endTag('div')?>

	<?echo Html::beginTag('div',['class'=>'group-data'])?>
	<?echo Html::label('Валюта площадки',null,['class'=>'col-lg-12 '])?>
		<?foreach($currency as $key=>$value):?>
			<?echo Html::beginTag('div',['class'=>'main-setting-hidden col-lg-12','currency'=>$value['id_currency']])?>

				<?echo Html::beginTag('div',['class'=>'col-lg-offset-1 col-lg-2'])?>
					<?echo Html::label($value['name'])?>
				<?echo Html::endTag('div')?>

				<?echo Html::beginTag('div',['class'=>'col-lg-3 padding-reset'])?>

					<?echo Html::label('Параметр',null,['class'=>'pull-left'])?>
					<?echo Html::beginTag('div',['class'=>'col-lg-7'])?>
						<?echo Html::input('text','currency_param_'.$value['id_currency'],
								$value['designation'],[
									'class' => 'form-control'
								]);
						?>
					<?echo Html::endTag('div')?>

				<?echo Html::endTag('div')?>

				<?echo Html::beginTag('div',['class'=>'col-lg-4'])?>

					<?echo Html::label('Отношение к 1 гривне',null,['class'=>'pull-left'])?>
					<?echo Html::beginTag('div',['class'=>'col-lg-4'])?>
						<?echo Html::input('text','currency_ratio_'.$value['id_currency'],
								$value['ratio'],[
									'class' => 'form-control'
								]);
						?>
					<?echo Html::endTag('div')?>

				<?echo Html::endTag('div')?>

				<?echo Html::beginTag('div',['class'=>'col-lg-2'])?>
					<?echo Html::label('По-умолчанию',null,['class'=>'pull-left padding-right-4'])?>
					<?echo Html::radio('defaultCurrency',$value['default_currency'],['class'=>'margin-top-10'])?>
				<?echo Html::endTag('div')?>

			<?echo Html::endTag('div')?>
		<?endforeach?>
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

	<?echo Html::beginTag('div',['class'=>'group-data '])?>
		<?echo Html::button('Далее',[
				'class'=>'btn col-lg-3 btn-primary pull-right',
				'onClick'=> 'nextBreadcrumbs()'
			]
		)?>
	<?echo Html::endTag('div')?>
<?echo Html::endTag('div')?>
