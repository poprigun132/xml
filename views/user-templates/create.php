<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UsersTemplates */

$this->title = 'Create Users Templates';
$this->params['breadcrumbs'][] = ['label' => 'Users Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
