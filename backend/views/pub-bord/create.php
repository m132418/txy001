<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PubBord */

$this->title = '创建公告';
$this->params['breadcrumbs'][] = ['label' => '公告', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pub-bord-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
