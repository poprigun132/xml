<?php
/**
 * Created by PhpStorm.
 * User: poprigun
 * Date: 27.10.14
 * Time: 13:32
 */
/* @var $parentModels parents models*/
/* @var $models parents models*/
use \yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>
<?echo Html::beginTag('div',['class'=>'modelSettings'])?>
	<?echo Html::tag('h1','Настройки моделей ',['class'=>'text-center'])?>
	<?echo Html::beginTag('div',['class'=>'col-lg-12'])?>
		<?echo Html::label('ID площадки',null,['class'=>'col-lg-offset-4 col-lg-3 text-center'])?>
		<?echo Html::label('Родительская модель',null,['class'=>'col-lg-3 text-center'])?>
		<?echo Html::label('Кол-во товаров',null,['class'=>'col-lg-2 text-center'])?>
	<?echo Html::endTag('div')?>

	<?foreach($models as $key=>$value):?>
		<?echo Html::beginTag('div',['class'=>'group-data'])?>

			<?echo Html::beginTag('div',['class'=>'col-lg-4'])?>
				<?echo Html::checkbox('checkbox_'.$value['id_model'],$value['checked'],[
					'onchange' => 'changeSelectModel('.$value['id_model'].')'
				])?>
				<?echo Html::label($value['name'])?>
			<?echo Html::endTag('div')?>

			<?echo Html::beginTag('div',['class'=>'col-lg-3'])?>
				<?echo Html::input('text','marketplace_'.$value['id_model'],'',[
					'class'=>'form-control',
					'onchange' => 'changeSelectModel('.$value['id_model'].')',
				])?>
			<?echo Html::endTag('div')?>

			<?echo Html::beginTag('div',['class'=>'col-lg-3'])?>
				<?
					if(ArrayHelper::keyExists($key,$parentModels)){
						$data = [
							'name' => 'model_'.$value['id_model'],
							'value' => $value['parent'],
							'id' => 'model_'.$value['id_model'],
							'data' => [],
							'options' => [
								'placeholder' => 'Select ...',
								'disabled' => 'disabled',
							],
						];
					}
					else{
						$data = [
							'name' => 'model_'.$value['id_model'],
							'value' => $value['parent'],
							'id' => 'model_'.$value['id_model'],
							'data' => $parentModels,
							'options' => [
								'placeholder' => 'Select ...',
								'onchange' => 'changeSelectModel('.$value['id_model'].')'
							],
						];
					}
				?>
				<?echo Select2::widget($data);
				?>
			<?echo Html::endTag('div')?>

			<?echo Html::beginTag('div',['class'=>'col-lg-2'])?>
				<?echo Html::input('text','count_'.$value['id_model'],$value['count'],[
					'class'=>'form-control',
					'onchange' => 'changeSelectModel('.$value['id_model'].')'
				])?>
			<?echo Html::endTag('div')?>

		<?echo Html::endTag('div')?>
	<?endforeach?>

	<?echo Html::button('Далее',[
			'class'=>'btn col-lg-3 margin-left-ten btn-primary pull-right margin-right-15',
			'onClick'=> 'nextBreadcrumbs()'
		])
	?>
	<?echo Html::button('Назад',[
			'class'=>'btn col-lg-3 btn-primary pull-right',
			'onClick'=> 'prevBreadcrumbs()'
		])
	?>
<?echo Html::endTag('div')?>
