<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Score */

$this->title = '赠送积分';
$this->params['breadcrumbs'][] = ['label' => '积分', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="score-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
